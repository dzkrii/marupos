<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $outlet = Auth::user()->currentOutlet;

        $categories = MenuCategory::where('outlet_id', $outlet->id)
            ->ordered()
            ->get();

        $query = MenuItem::where('outlet_id', $outlet->id)
            ->with('category')
            ->orderBy('sort_order');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('menu_category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menuItems = $query->paginate(20)->withQueryString();

        return view('menu-items.index', compact('menuItems', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $outlet = Auth::user()->currentOutlet;
        $categories = MenuCategory::where('outlet_id', $outlet->id)
            ->active()
            ->ordered()
            ->get();

        return view('menu-items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'track_stock' => 'boolean',
            'stock' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $outlet = Auth::user()->currentOutlet;

        // Verify category belongs to outlet
        $category = MenuCategory::where('id', $validated['menu_category_id'])
            ->where('outlet_id', $outlet->id)
            ->firstOrFail();

        // Generate unique slug
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (MenuItem::where('outlet_id', $outlet->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-items', 'public');
        }

        // Get max sort_order
        $maxSort = MenuItem::where('outlet_id', $outlet->id)->max('sort_order') ?? 0;

        MenuItem::create([
            'outlet_id' => $outlet->id,
            'menu_category_id' => $category->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $validated['sku'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'price' => $validated['price'],
            'cost_price' => $validated['cost_price'] ?? null,
            'track_stock' => $validated['track_stock'] ?? false,
            'stock' => $validated['stock'] ?? null,
            'is_available' => $validated['is_available'] ?? true,
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $maxSort + 1,
        ]);

        return redirect()->route('menu-items.index')
            ->with('success', 'Menu item berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        $this->authorizeOutlet($menuItem);

        $outlet = Auth::user()->currentOutlet;
        $categories = MenuCategory::where('outlet_id', $outlet->id)
            ->active()
            ->ordered()
            ->get();

        return view('menu-items.edit', compact('menuItem', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $this->authorizeOutlet($menuItem);

        $validated = $request->validate([
            'menu_category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'track_stock' => 'boolean',
            'stock' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $outlet = Auth::user()->currentOutlet;

        // Verify category belongs to outlet
        MenuCategory::where('id', $validated['menu_category_id'])
            ->where('outlet_id', $outlet->id)
            ->firstOrFail();

        // Regenerate slug if name changed
        if ($validated['name'] !== $menuItem->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $count = 1;
            while (MenuItem::where('outlet_id', $outlet->id)
                ->where('slug', $slug)
                ->where('id', '!=', $menuItem->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        // Handle remove image
        if ($request->boolean('remove_image') && $menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
            $validated['image'] = null;
        }

        $validated['track_stock'] = $request->boolean('track_stock');
        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_active'] = $request->boolean('is_active');

        $menuItem->update($validated);

        return redirect()->route('menu-items.index')
            ->with('success', 'Menu item berhasil diperbarui.');
    }

    /**
     * Toggle availability status.
     */
    public function toggleAvailability(MenuItem $menuItem)
    {
        $this->authorizeOutlet($menuItem);

        $menuItem->update([
            'is_available' => !$menuItem->is_available,
        ]);

        $status = $menuItem->is_available ? 'tersedia' : 'tidak tersedia';

        return back()->with('success', "Menu {$menuItem->name} sekarang {$status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $this->authorizeOutlet($menuItem);

        // Delete image if exists
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()->route('menu-items.index')
            ->with('success', 'Menu item berhasil dihapus.');
    }

    /**
     * Authorize that the resource belongs to current outlet.
     */
    private function authorizeOutlet(MenuItem $menuItem): void
    {
        $outlet = Auth::user()->currentOutlet;
        if ($menuItem->outlet_id !== $outlet->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
