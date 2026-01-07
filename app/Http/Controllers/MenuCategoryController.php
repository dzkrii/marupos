<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outlet = Auth::user()->currentOutlet;
        $categories = MenuCategory::where('outlet_id', $outlet->id)
            ->ordered()
            ->withCount('menuItems')
            ->get();

        return view('menu-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $outlet = Auth::user()->currentOutlet;

        // Generate unique slug
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (MenuCategory::where('outlet_id', $outlet->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Get max sort_order
        $maxSort = MenuCategory::where('outlet_id', $outlet->id)->max('sort_order') ?? 0;

        MenuCategory::create([
            'outlet_id' => $outlet->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'icon' => $validated['icon'] ?? null,
            'sort_order' => $maxSort + 1,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('menu-categories.index')
            ->with('success', 'Kategori menu berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuCategory $menuCategory)
    {
        $this->authorizeOutlet($menuCategory);
        return view('menu-categories.edit', compact('menuCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuCategory $menuCategory)
    {
        $this->authorizeOutlet($menuCategory);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $outlet = Auth::user()->currentOutlet;

        // Regenerate slug if name changed
        if ($validated['name'] !== $menuCategory->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $count = 1;
            while (MenuCategory::where('outlet_id', $outlet->id)
                ->where('slug', $slug)
                ->where('id', '!=', $menuCategory->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $menuCategory->update($validated);

        return redirect()->route('menu-categories.index')
            ->with('success', 'Kategori menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuCategory $menuCategory)
    {
        $this->authorizeOutlet($menuCategory);

        // Check if category has menu items
        if ($menuCategory->menuItems()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang masih memiliki menu.');
        }

        $menuCategory->delete();

        return redirect()->route('menu-categories.index')
            ->with('success', 'Kategori menu berhasil dihapus.');
    }

    /**
     * Update sort order via AJAX.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:menu_categories,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        $outlet = Auth::user()->currentOutlet;

        foreach ($validated['items'] as $item) {
            MenuCategory::where('id', $item['id'])
                ->where('outlet_id', $outlet->id)
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Authorize that the resource belongs to current outlet.
     */
    private function authorizeOutlet(MenuCategory $menuCategory): void
    {
        $outlet = Auth::user()->currentOutlet;
        if ($menuCategory->outlet_id !== $outlet->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
