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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->integer('unit_size')->nullable();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('hsn_code')->nullable();
            $table->integer('min_quantity')->nullable();
            $table->integer('max_quantity')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->decimal('special_price', 10, 2)->nullable();
            $table->string('tax_type')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('tax_percentage')->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_cod')->default(true);
            $table->boolean('is_refundable')->default(true);
            $table->json('tags')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->integer('eastimate_shiping_time')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('SET NULL');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('SET NULL');
            $table->foreign('created_by')->references('id')->on('ecom_admins')->onDelete('SET NULL');
            $table->foreign('updated_by')->references('id')->on('ecom_admins')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
