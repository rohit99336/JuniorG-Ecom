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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variant_id');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price')->default(0);
            $table->decimal('total')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('tax')->default(0);
            $table->decimal('shipping')->default(0);
            $table->decimal('grand_total')->default(0);
            $table->decimal('coupon_discount')->default(0);
            $table->string('coupon_discount_type')->default(0);
            $table->decimal('coupon_discount_value')->default(0);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            // Delete if product or  product variant is deleted
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
