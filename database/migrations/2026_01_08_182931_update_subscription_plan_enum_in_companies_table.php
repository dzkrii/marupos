<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Update subscription_plan enum to match subscription_plans table slugs.
     */
    public function up(): void
    {
        // First, update existing data to match new enum values
        // 'basic' -> 'starter', 'pro' -> 'professional'
        DB::table('companies')->where('subscription_plan', 'basic')->update(['subscription_plan' => 'free']);
        DB::table('companies')->where('subscription_plan', 'pro')->update(['subscription_plan' => 'free']);
        
        // Now modify the enum
        DB::statement("ALTER TABLE companies MODIFY subscription_plan ENUM('free', 'starter', 'professional', 'enterprise') DEFAULT 'free'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update data back
        DB::table('companies')->where('subscription_plan', 'starter')->update(['subscription_plan' => 'free']);
        DB::table('companies')->where('subscription_plan', 'professional')->update(['subscription_plan' => 'free']);
        
        // Revert to original enum values
        DB::statement("ALTER TABLE companies MODIFY subscription_plan ENUM('free', 'basic', 'pro', 'enterprise') DEFAULT 'free'");
    }
};
