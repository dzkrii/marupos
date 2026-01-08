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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // Unique order ID for Midtrans
            $table->foreignId('subscription_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->integer('amount'); // Jumlah pembayaran dalam Rupiah
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'refunded'])->default('pending');
            $table->string('payment_type')->nullable(); // credit_card, bank_transfer, gopay, etc
            $table->string('transaction_id')->nullable(); // Midtrans transaction ID
            $table->string('snap_token')->nullable(); // Midtrans Snap Token
            $table->json('payment_details')->nullable(); // Detail pembayaran dari Midtrans
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Temporary registration data (sebelum user register)
            $table->string('temp_name')->nullable();
            $table->string('temp_email')->nullable();
            $table->string('temp_phone')->nullable();
            $table->string('temp_restaurant_name')->nullable();
            
            $table->timestamps();
            
            $table->index(['status', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
