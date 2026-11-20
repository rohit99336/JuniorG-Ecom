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
        Schema::create('card_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('card_number')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('expiry_month')->nullable();
            $table->string('expiry_year')->nullable();
            $table->string('cvv')->nullable();
            $table->string('card_type')->nullable();
            $table->string('last_four_digit')->nullable();
            $table->string('brand')->nullable();
            $table->string('funding')->nullable();
            $table->string('country')->nullable();
            $table->string('bank')->nullable();
            $table->string('card_issuer')->nullable();
            $table->string('card_category')->nullable();
            $table->string('card_class')->nullable();
            $table->string('card_product')->nullable();
            $table->string('card_type_code')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_details');
    }
};
