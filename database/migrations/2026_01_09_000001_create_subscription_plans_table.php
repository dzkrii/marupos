<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Starter, Professional, Enterprise
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('price_monthly'); // Harga bulanan dalam Rupiah
            $table->integer('price_yearly'); // Harga tahunan dalam Rupiah
            $table->integer('max_outlets')->nullable(); // null = unlimited
            $table->integer('max_tables')->nullable(); // null = unlimited
            $table->integer('max_employees')->nullable(); // null = unlimited
            $table->json('features')->nullable(); // List fitur dalam JSON
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
