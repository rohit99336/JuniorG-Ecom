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
        Schema::table('ecom_masters', function (Blueprint $table) {
            $table->time('start_time')->nullable()->after('map_link');
            $table->time('close_time')->nullable()->after('start_time');
            $table->float('shipping_charge')->nullable()->after('close_time');
            $table->float('free_shipping_amount')->nullable()->after('shipping_charge');
            $table->integer('return_days')->nullable()->after('free_shipping_amount');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecom_masters', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('close_time');
            $table->dropColumn('shipping_charge');
            $table->dropColumn('free_shipping_amount');
            $table->dropColumn('currency');
        });
    }
};
