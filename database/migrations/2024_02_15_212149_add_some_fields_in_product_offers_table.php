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
        Schema::table('product_offers', function (Blueprint $table) {
            // add fields
            $table->string('horizontal_subheading')->nullable()->after('name');
            $table->string('vertical_subheading')->nullable()->after('horizontal_subheading');
            $table->string('heading')->nullable()->after('vertical_subheading');
            $table->string('offer_text')->nullable()->after('heading');
            $table->string('button_text')->nullable()->after('offer_text');
            $table->string('button_link')->nullable()->after('button_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_offers', function (Blueprint $table) {
            // drop columns
            $table->dropColumn('horizontal_subheading');
            $table->dropColumn('vertical_subheading');
            $table->dropColumn('heading');
            $table->dropColumn('offer_text');
            $table->dropColumn('button_text');
            $table->dropColumn('button_link');
        });
    }
};
