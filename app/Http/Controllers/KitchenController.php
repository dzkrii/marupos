<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitchenController extends Controller
{
    /**
     * Display the Kitchen Display System (KDS) board.
     */
    public function index(Request $request)
    {
        // Get current outlet from user (via relation accessor mechanism)
        // If your User model has 'current_outlet_id' accessor or similar, use that.
        // Based on analysis, 'current_outlet' returns the model.
        $outlet = $request->user()->current_outlet;
        
        if (!$outlet) {
            // Fallback or error if no outlet selected
            // In real app, middleware handles this.
             abort(403, 'Tidak ada outlet yang dipilih untuk pengguna ini.');
        }

        $orders = Order::where('outlet_id', $outlet->id)
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PREPARING]) // Orders visible in kitchen
            ->with(['items.menuItem', 'table'])
            ->orderBy('confirmed_at', 'asc') // FIFO
            ->orderBy('created_at', 'asc')
            ->get();

        return view('kitchen.index', compact('orders'));
    }

    /**
     * Update the status of a specific order item.
     */
    public function updateItemStatus(Request $request, OrderItem $item)
    {
        $outlet = $request->user()->current_outlet;
        
        if (!$outlet || $item->order->outlet_id !== $outlet->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', [OrderItem::STATUS_PREPARING, OrderItem::STATUS_READY, OrderItem::STATUS_SERVED]),
        ]);

        $item->update([
            'status' => $validated['status']
        ]);

        // Check if we should update the parent Order status
        $this->syncOrderStatus($item->order);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Status item diperbarui', 'status' => $item->status]);
        }

        return back()->with('success', 'Status item diperbarui.');
    }

    /**
     * Mark an entire order as ready (all items ready).
     */
    public function markOrderReady(Request $request, Order $order)
    {
        $outlet = $request->user()->current_outlet;

         if (!$outlet || $order->outlet_id !== $outlet->id) {
            abort(403);
        }

        DB::transaction(function () use ($order) {
            // Update all items that are not yet ready/served/cancelled
            $order->items()
                ->whereNotIn('status', [OrderItem::STATUS_READY, OrderItem::STATUS_SERVED, OrderItem::STATUS_CANCELLED])
                ->update(['status' => OrderItem::STATUS_READY]);

            $order->update([
                'status' => Order::STATUS_READY
            ]);
        });

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Pesanan ditandai sebagai Siap']);
        }

        return back()->with('success', 'Pesanan ditandai sebagai Siap.');
    }

    /**
     * Get new orders count (API endpoint for notification polling).
     */
    public function checkNewOrders(Request $request)
    {
        $outlet = $request->user()->current_outlet;
        
        if (!$outlet) {
            return response()->json(['error' => 'No outlet selected'], 403);
        }

        // Get last seen order ID from session or param
        $lastSeenOrderId = $request->input('last_order_id', session('kitchen_last_order_id', 0));

        // Get orders that are newer than last seen
        $newOrders = Order::where('outlet_id', $outlet->id)
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PREPARING])
            ->where('id', '>', $lastSeenOrderId)
            ->with(['items', 'table'])
            ->orderBy('id', 'desc')
            ->get();

        $hasNewOrders = $newOrders->isNotEmpty();
        $latestOrderId = Order::where('outlet_id', $outlet->id)
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PREPARING])
            ->max('id') ?? 0;

        return response()->json([
            'has_new_orders' => $hasNewOrders,
            'new_orders_count' => $newOrders->count(),
            'latest_order_id' => $latestOrderId,
            'new_orders' => $newOrders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'table' => $order->table ? $order->table->name : 'Takeaway',
                    'items_count' => $order->items->count(),
                    'order_type' => $order->order_type,
                ];
            })
        ]);
    }

    /**
     * Sync Order status based on its items.
     */
    protected function syncOrderStatus(Order $order)
    {
        $items = $order->items;
        
        // If all items are ready or served, mark order as Ready
        // (Ignoring cancelled items for this logic, hopefully)
        $activeItems = $items->reject(fn($i) => $i->status === OrderItem::STATUS_CANCELLED);
        
        if ($activeItems->isEmpty()) {
            return;
        }

        $allReady = $activeItems->every(fn($i) => in_array($i->status, [OrderItem::STATUS_READY, OrderItem::STATUS_SERVED]));
        $anyPreparing = $activeItems->contains(fn($i) => $i->status === OrderItem::STATUS_PREPARING);

        if ($allReady && $order->status !== Order::STATUS_READY) {
            $order->update(['status' => Order::STATUS_READY]);
        } elseif ($anyPreparing && $order->status === Order::STATUS_CONFIRMED) {
             // If currently just confirmed, but someone started prepping, move order to Preparing
             $order->update(['status' => Order::STATUS_PREPARING]);
        }
    }
}
