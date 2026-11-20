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
    Schema::create('product_exports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products');
        $table->foreignId('product_variant_id')->constrained('product_variants');
        $table->foreignId('export_by')->nullable()->constrained('ecom_admins')->onDelete('cascade');
        $table->string('name')->nullable();
        $table->string('phone', 15)->nullable();
        $table->string('email')->nullable();
        $table->integer('old_sctock')->unsigned()->default(0);
        $table->integer('current_sctock')->unsigned()->default(0);
        $table->integer('quantity')->unsigned()->default(0);
        $table->decimal('price', 10, 2)->default(0.00);
        $table->text('note')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('pincode', 10)->nullable();
        $table->string('address')->nullable();
        $table->enum('status', ['pending', 'processing', 'delivered'])->default('pending')->comment('export status');
        $table->enum('type', ['import', 'export'])->default('export');
        $table->foreignId('deleted_by')->nullable()->constrained('ecom_admins')->onDelete('cascade');
        $table->softDeletes();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_exports');
    }
};
