<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outlet;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QrOrderController extends Controller
{
    /**
     * Display public menu page via QR code.
     */
    public function menu($outletSlug, $tableQr)
    {
        // Find outlet by slug
        $outlet = Outlet::where('slug', $outletSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // Check if QR access code is required
        if ($outlet->qr_access_code && Session::get('qr_access_code_' . $outlet->id) !== $outlet->qr_access_code) {
            return redirect()->route('qr.login', [$outletSlug, $tableQr]);
        }

        // Find table by QR code
        $table = Table::where('outlet_id', $outlet->id)
            ->where('qr_code', $tableQr)
            ->where('is_active', true)
            ->with('area')
            ->firstOrFail();

        // Get all active menu categories with items
        $categories = MenuCategory::where('outlet_id', $outlet->id)
            ->active()
            ->ordered()
            ->with(['menuItems' => function ($query) {
                $query->available()->orderBy('sort_order');
            }])
            ->get();

        // Get all menu items for general display
        $menuItems = MenuItem::where('outlet_id', $outlet->id)
            ->available()
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        // Initialize cart in session if not exists
        if (!Session::has('qr_cart')) {
            Session::put('qr_cart', [
                'outlet_id' => $outlet->id,
                'table_id' => $table->id,
                'items' => [],
                'total' => 0
            ]);
        }

        return view('qr.menu', compact('outlet', 'table', 'categories', 'menuItems'));
    }

    /**
     * Show login page for QR access.
     */
    public function login($outletSlug, $tableQr)
    {
        $outlet = Outlet::where('slug', $outletSlug)->firstOrFail();
        return view('qr.login', compact('outlet', 'outletSlug', 'tableQr'));
    }

    /**
     * Verify QR access code.
     */
    public function verify(Request $request, $outletSlug, $tableQr)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        $outlet = Outlet::where('slug', $outletSlug)->firstOrFail();

        if ($request->access_code !== $outlet->qr_access_code) {
            return back()->with('error', 'Kode akses salah. Silakan coba lagi.');
        }

        // Store access in session
        Session::put('qr_access_code_' . $outlet->id, $outlet->qr_access_code);

        return redirect()->route('qr.menu', [$outletSlug, $tableQr]);
    }

    /**
     * Add item to cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $menuItem = MenuItem::findOrFail($request->menu_item_id);

        // Check if item is available and in stock
        if (!$menuItem->is_available || !$menuItem->isInStock()) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak tersedia atau stok habis.'
            ], 400);
        }

        $cart = Session::get('qr_cart', [
            'outlet_id' => $menuItem->outlet_id,
            'table_id' => null,
            'items' => [],
            'total' => 0
        ]);

        // Check if item already exists in cart
        $existingIndex = null;
        foreach ($cart['items'] as $index => $item) {
            if ($item['menu_item_id'] == $menuItem->id && $item['notes'] == $request->notes) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== null) {
            // Update quantity
            $cart['items'][$existingIndex]['quantity'] += $request->quantity;
            $cart['items'][$existingIndex]['subtotal'] = $cart['items'][$existingIndex]['quantity'] * $menuItem->price;
        } else {
            // Add new item
            $cart['items'][] = [
                'menu_item_id' => $menuItem->id,
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => $request->quantity,
                'notes' => $request->notes,
                'subtotal' => $menuItem->price * $request->quantity,
                'image' => $menuItem->image,
            ];
        }

        // Recalculate total
        $cart['total'] = collect($cart['items'])->sum('subtotal');

        Session::put('qr_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil ditambahkan ke keranjang.',
            'cart' => $cart,
            'cart_count' => count($cart['items'])
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'index' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('qr_cart');

        if (!isset($cart['items'][$request->index])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan.'
            ], 404);
        }

        $cart['items'][$request->index]['quantity'] = $request->quantity;
        $cart['items'][$request->index]['subtotal'] = 
            $cart['items'][$request->index]['quantity'] * $cart['items'][$request->index]['price'];

        // Recalculate total
        $cart['total'] = collect($cart['items'])->sum('subtotal');

        Session::put('qr_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui.',
            'cart' => $cart
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart($index)
    {
        $cart = Session::get('qr_cart');

        if (!isset($cart['items'][$index])) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan.'
            ], 404);
        }

        unset($cart['items'][$index]);
        $cart['items'] = array_values($cart['items']); // Re-index array

        // Recalculate total
        $cart['total'] = collect($cart['items'])->sum('subtotal');

        Session::put('qr_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus.',
            'cart' => $cart,
            'cart_count' => count($cart['items'])
        ]);
    }

    /**
     * View cart page.
     */
    public function viewCart()
    {
        $cart = Session::get('qr_cart');

        if (!$cart || empty($cart['items'])) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong.');
        }

        $outlet = Outlet::findOrFail($cart['outlet_id']);
        $table = Table::find($cart['table_id']);

        return view('qr.cart', compact('cart', 'outlet', 'table'));
    }

    /**
     * Submit order from cart.
     */
    public function submitOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = Session::get('qr_cart');

        if (!$cart || empty($cart['items'])) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong.');
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'outlet_id' => $cart['outlet_id'],
                'table_id' => $cart['table_id'],
                'user_id' => null, // QR order has no user (staff)
                'order_type' => Order::TYPE_QR_ORDER,
                'status' => Order::STATUS_CONFIRMED,
                'confirmed_at' => now(),
                'customer_name' => $request->customer_name ?: 'Customer',
                'customer_phone' => $request->customer_phone,
                'guest_count' => 1,
                'subtotal' => $cart['total'],
                'tax_amount' => 0,
                'discount_amount' => 0,
                'service_charge' => 0,
                'total_amount' => $cart['total'],
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cart['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'menu_item_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'notes' => $item['notes'],
                    'status' => OrderItem::STATUS_PENDING,
                ]);

                // Decrease stock if tracked
                $menuItem = MenuItem::find($item['menu_item_id']);
                if ($menuItem && $menuItem->track_stock) {
                    $menuItem->decreaseStock($item['quantity']);
                }
            }

            // Update table status
            if ($cart['table_id']) {
                $table = Table::find($cart['table_id']);
                if ($table && $table->status === Table::STATUS_AVAILABLE) {
                    $table->occupy();
                }
            }

            DB::commit();

            // Clear cart
            Session::forget('qr_cart');

            return redirect()->route('qr.confirmation', ['orderNumber' => $order->order_number])
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Order confirmation page.
     */
    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items', 'table.area', 'outlet'])
            ->firstOrFail();

        return view('qr.confirmation', compact('order'));
    }

    /**
     * Track order status.
     */
    public function trackOrder($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.menuItem', 'table.area', 'outlet'])
            ->firstOrFail();

        return view('qr.track', compact('order'));
    }

    /**
     * Print receipt.
     */
    public function printReceipt($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items', 'table.area', 'outlet'])
            ->firstOrFail();

        return view('receipts.order', compact('order'));
    }

    /**
     * Get order status (AJAX endpoint for auto-refresh).
     */
    public function getOrderStatus($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items'])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'status' => $order->status,
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->menu_item_name,
                    'quantity' => $item->quantity,
                    'status' => $item->status,
                ];
            })
        ]);
    }
}
