<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Creates a new tenant (Company) with default outlet and owner user.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'restaurant_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Use transaction to ensure all or nothing
        $user = DB::transaction(function () use ($request) {
            // Create company (tenant)
            $company = Company::create([
                'name' => $request->restaurant_name,
                'slug' => Str::slug($request->restaurant_name) . '-' . Str::random(5),
                'email' => $request->email,
                'phone' => $request->phone,
                'subscription_plan' => 'free',
                'is_active' => true,
            ]);

            // Create default outlet
            $outlet = Outlet::create([
                'company_id' => $company->id,
                'name' => $request->restaurant_name . ' - Pusat',
                'slug' => 'pusat',
                'code' => strtoupper(Str::random(6)),
                'phone' => $request->phone,
                'timezone' => 'Asia/Jakarta',
                'is_active' => true,
            ]);

            // Create owner user
            $user = User::create([
                'company_id' => $company->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // Attach user to outlet as owner
            $user->outlets()->attach($outlet->id, [
                'role' => 'owner',
                'is_default' => true,
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        // Set current outlet in session
        session(['current_outlet_id' => $user->defaultOutlet()?->id]);

        return redirect(route('dashboard', absolute: false));
    }
}

