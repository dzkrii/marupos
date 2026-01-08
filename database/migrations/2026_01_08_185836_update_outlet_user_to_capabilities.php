<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration converts the single 'role' column to a 'capabilities' JSON column
     * allowing users to have multiple capabilities (e.g., cashier + kitchen).
     */
    public function up(): void
    {
        // First, add the new capabilities column
        Schema::table('outlet_user', function (Blueprint $table) {
            $table->json('capabilities')->nullable()->after('role');
        });

        // Migrate existing role data to capabilities
        DB::table('outlet_user')->get()->each(function ($record) {
            $role = $record->role;
            
            // Convert role to capabilities array
            // Owner and manager get all capabilities by default
            $capabilities = match ($role) {
                'owner' => ['dashboard', 'menu_management', 'table_management', 'cashier', 'orders', 'kitchen', 'employees', 'reports'],
                'manager' => ['dashboard', 'menu_management', 'table_management', 'cashier', 'orders', 'kitchen', 'employees', 'reports'],
                'cashier' => ['dashboard', 'cashier', 'orders'],
                'waiter' => ['dashboard', 'orders'],
                'kitchen' => ['dashboard', 'kitchen', 'orders'],
                default => ['dashboard'],
            };
            
            DB::table('outlet_user')
                ->where('id', $record->id)
                ->update(['capabilities' => json_encode($capabilities)]);
        });

        // Make capabilities not nullable and drop the old role column
        Schema::table('outlet_user', function (Blueprint $table) {
            $table->json('capabilities')->nullable(false)->change();
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the role column
        Schema::table('outlet_user', function (Blueprint $table) {
            $table->enum('role', ['owner', 'manager', 'cashier', 'waiter', 'kitchen'])->default('cashier')->after('user_id');
        });

        // Migrate capabilities back to role (take the first/primary one)
        DB::table('outlet_user')->get()->each(function ($record) {
            $capabilities = json_decode($record->capabilities, true);
            
            // Determine primary role based on capabilities
            $role = 'cashier'; // default
            
            if (in_array('employees', $capabilities) && in_array('reports', $capabilities)) {
                $role = count($capabilities) >= 7 ? 'owner' : 'manager';
            } elseif (in_array('cashier', $capabilities)) {
                $role = 'cashier';
            } elseif (in_array('kitchen', $capabilities)) {
                $role = 'kitchen';
            } elseif (in_array('orders', $capabilities)) {
                $role = 'waiter';
            }
            
            DB::table('outlet_user')
                ->where('id', $record->id)
                ->update(['role' => $role]);
        });

        // Drop capabilities column
        Schema::table('outlet_user', function (Blueprint $table) {
            $table->dropColumn('capabilities');
        });
    }
};
