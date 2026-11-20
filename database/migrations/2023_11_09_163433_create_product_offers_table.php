<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\text;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('offer_code')->nullable();
            $table->enum('offer_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('offer_value', 8, 2)->nullable();
            $table->timestamp('offer_start_time')->nullable();
            $table->timestamp('offer_end_time')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('is_sel_all')->nullable();
            $table->text('terms')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('ecom_admins')->onDelete('SET NULL');
            $table->foreign('updated_by')->references('id')->on('ecom_admins')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_offers');
    }
};
