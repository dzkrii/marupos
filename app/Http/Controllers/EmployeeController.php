<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CapabilityMiddleware;
use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees for current outlet.
     */
    public function index(Request $request)
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet) {
            abort(403, 'Tidak ada outlet yang dipilih.');
        }

        // Get employees for current outlet
        $query = $outlet->users()->with('outlets');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Capability filter
        if ($request->filled('capability')) {
            $capability = $request->capability;
            $query->where(function ($q) use ($capability) {
                $q->whereRaw("JSON_CONTAINS(outlet_user.capabilities, ?)", ['"' . $capability . '"']);
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $employees = $query->orderBy('name', 'asc')->paginate(12);

        // Get all available capabilities for filter dropdown
        $capabilities = CapabilityMiddleware::CAPABILITIES;

        return view('employees.index', compact('employees', 'capabilities'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet) {
            abort(403, 'Tidak ada outlet yang dipilih.');
        }

        $capabilities = CapabilityMiddleware::CAPABILITIES;
        $rolePresets = CapabilityMiddleware::getRolePresets();

        return view('employees.create', compact('capabilities', 'rolePresets'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet) {
            abort(403, 'Tidak ada outlet yang dipilih.');
        }

        $validCapabilities = array_keys(CapabilityMiddleware::CAPABILITIES);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'capabilities' => ['required', 'array', 'min:1'],
            'capabilities.*' => ['string', 'in:' . implode(',', $validCapabilities)],
            'pin' => 'nullable|digits:6',
            'avatar' => 'nullable|image|max:2048',
            'is_default' => 'boolean',
        ], [
            'capabilities.required' => 'Pilih minimal satu kemampuan akses.',
            'capabilities.min' => 'Pilih minimal satu kemampuan akses.',
        ]);

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'company_id' => $outlet->company_id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'pin' => $validated['pin'] ?? null,
                'is_active' => true,
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->update(['avatar' => $avatarPath]);
            }

            // Always include dashboard capability
            $capabilities = $validated['capabilities'];
            if (!in_array('dashboard', $capabilities)) {
                array_unshift($capabilities, 'dashboard');
            }

            // Attach to outlet with capabilities
            $user->outlets()->attach($outlet->id, [
                'capabilities' => json_encode($capabilities),
                'is_default' => $request->boolean('is_default', false),
            ]);

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(User $employee)
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet || !$employee->hasAccessTo($outlet)) {
            abort(403);
        }

        // Get employee's capabilities at current outlet
        $currentCapabilities = $employee->capabilitiesAt($outlet);

        $capabilities = CapabilityMiddleware::CAPABILITIES;
        $rolePresets = CapabilityMiddleware::getRolePresets();

        return view('employees.edit', compact('employee', 'currentCapabilities', 'capabilities', 'rolePresets'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, User $employee)
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet || !$employee->hasAccessTo($outlet)) {
            abort(403);
        }

        $validCapabilities = array_keys(CapabilityMiddleware::CAPABILITIES);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'capabilities' => ['required', 'array', 'min:1'],
            'capabilities.*' => ['string', 'in:' . implode(',', $validCapabilities)],
            'password' => 'nullable|string|min:8',
            'pin' => 'nullable|digits:6',
            'avatar' => 'nullable|image|max:2048',
            'remove_avatar' => 'boolean',
        ], [
            'capabilities.required' => 'Pilih minimal satu kemampuan akses.',
            'capabilities.min' => 'Pilih minimal satu kemampuan akses.',
        ]);

        DB::beginTransaction();

        try {
            // Update user details
            $updateData = [
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
            ];

            // Update password if provided
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            // Update PIN if provided
            if (isset($validated['pin'])) {
                $updateData['pin'] = $validated['pin'];
            }

            $employee->update($updateData);

            // Handle avatar removal
            if ($request->boolean('remove_avatar') && $employee->avatar) {
                \Storage::disk('public')->delete($employee->avatar);
                $employee->update(['avatar' => null]);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($employee->avatar) {
                    \Storage::disk('public')->delete($employee->avatar);
                }
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $employee->update(['avatar' => $avatarPath]);
            }

            // Always include dashboard capability
            $capabilities = $validated['capabilities'];
            if (!in_array('dashboard', $capabilities)) {
                array_unshift($capabilities, 'dashboard');
            }

            // Update capabilities at outlet
            $employee->outlets()->updateExistingPivot($outlet->id, [
                'capabilities' => json_encode($capabilities),
            ]);

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', 'Karyawan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal memperbarui karyawan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle employee active status.
     */
    public function toggleStatus(User $employee)
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet || !$employee->hasAccessTo($outlet)) {
            abort(403);
        }

        $employee->update([
            'is_active' => !$employee->is_active
        ]);

        $status = $employee->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Karyawan berhasil {$status}.");
    }

    /**
     * Reset employee PIN.
     */
    public function resetPin(User $employee)
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet || !$employee->hasAccessTo($outlet)) {
            abort(403);
        }

        // Generate random 6-digit PIN
        $newPin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $employee->update(['pin' => $newPin]);

        return back()->with('success', "PIN berhasil direset menjadi: {$newPin}");
    }

    /**
     * Remove the specified employee (soft delete).
     */
    public function destroy(User $employee)
    {
        $outlet = Auth::user()->current_outlet;

        if (!$outlet || !$employee->hasAccessTo($outlet)) {
            abort(403);
        }

        // Prevent self-deletion
        if ($employee->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Detach from outlet
        $employee->outlets()->detach($outlet->id);

        // If employee has no more outlets, soft delete the user
        if ($employee->outlets()->count() === 0) {
            $employee->delete();
        }

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
