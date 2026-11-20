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
        Schema::table('products', function (Blueprint $table) {
            // add shiping cost
            $table->decimal('shipping_cost', 10, 2)->nullable()->after('cost');
        });

        Schema::table('product_variants', function (Blueprint $table) {
            // add shiping cost
            $table->decimal('shipping_cost', 10, 2)->nullable()->after('cost');
        });

        Schema::table('customers', function (Blueprint $table) {
            // add shiping cost
            $table->integer('zip_code')->nullable()->after('address');
            $table->string('last_name')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // drop shipping cost
            $table->dropColumn('shipping_cost');
        });

        Schema::table('product_variants', function (Blueprint $table) {
            // drop shipping cost
            $table->dropColumn('shipping_cost');
        });

        Schema::table('customers', function (Blueprint $table) {
            // drop shipping cost
            $table->dropColumn('zip_code');
            $table->dropColumn('last_name');
        });
    }
};
