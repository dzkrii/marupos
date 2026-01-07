<?php

namespace App\Http\Controllers;

use App\Models\TableArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outlet = Auth::user()->currentOutlet;
        $areas = TableArea::where('outlet_id', $outlet->id)
            ->orderBy('sort_order')
            ->withCount('tables')
            ->get();

        return view('table-areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('table-areas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $outlet = Auth::user()->currentOutlet;

        // Get max sort_order
        $maxSort = TableArea::where('outlet_id', $outlet->id)->max('sort_order') ?? 0;

        TableArea::create([
            'outlet_id' => $outlet->id,
            'name' => $validated['name'],
            'sort_order' => $maxSort + 1,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('table-areas.index')
            ->with('success', 'Area meja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TableArea $tableArea)
    {
        $this->authorizeOutlet($tableArea);
        return view('table-areas.edit', compact('tableArea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TableArea $tableArea)
    {
        $this->authorizeOutlet($tableArea);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $tableArea->update($validated);

        return redirect()->route('table-areas.index')
            ->with('success', 'Area meja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TableArea $tableArea)
    {
        $this->authorizeOutlet($tableArea);

        // Check if area has tables
        if ($tableArea->tables()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus area yang masih memiliki meja.');
        }

        $tableArea->delete();

        return redirect()->route('table-areas.index')
            ->with('success', 'Area meja berhasil dihapus.');
    }

    /**
     * Authorize that the resource belongs to current outlet.
     */
    private function authorizeOutlet(TableArea $tableArea): void
    {
        $outlet = Auth::user()->currentOutlet;
        if ($tableArea->outlet_id !== $outlet->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
