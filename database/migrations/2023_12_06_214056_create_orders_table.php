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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('shipping_address_id');
            $table->unsignedBigInteger('billing_address_id');
            $table->unsignedBigInteger('shipping_method_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('currency_id');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('shipping', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('payment_gateway')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_details')->nullable();
            $table->string('shipping_number')->nullable();
            $table->string('shipping_details')->nullable();
            $table->string('shipping_status')->nullable();
            $table->string('shipping_label')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('tracking_link')->nullable();
            $table->string('tracking_details')->nullable();
            $table->string('tracking_status')->nullable();
            $table->string('tracking_label')->nullable();
            $table->string('tracking_shipped')->nullable();
            $table->string('tracking_delivered')->nullable();
            $table->string('tracking_delivery_date')->nullable();
            $table->string('tracking_delivery_time')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'declined', 'refunded', 'cancelled', 'failed'])->default('pending');
            $table->enum('payment_methods',['cod','paypal','stripe','paystack','flutterwave','bank_transfer'])->default('cod');
            $table->text('notes')->nullable();
            $table->text('customer_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            // $table->foreign('shipping_address_id')->references('id')->on('addresses')->cascadeOnDelete();
            // $table->foreign('billing_address_id')->references('id')->on('addresses')->cascadeOnDelete();
            // $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->cascadeOnDelete();
            // $table->foreign('payment_method_id')->references('id')->on('payment_methods')->cascadeOnDelete();
            // $table->foreign('coupon_id')->references('id')->on('coupons')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
