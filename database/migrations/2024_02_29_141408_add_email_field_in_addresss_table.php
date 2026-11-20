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
        Schema::table('addresses', function (Blueprint $table) {
            // add email field
            $table->string('email')->nullable()->after('phone');

            // drop billing,shipping and default
            $table->dropColumn('default');
            $table->dropColumn('billing');
            $table->dropColumn('shipping');

            $table->string('type')->nullable()->after('email');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            //  drop email field
            $table->dropColumn('email');
            $table->string('default')->nullable();
            $table->string('billing')->nullable();
            $table->string('shipping')->nullable();
            $table->dropColumn('type');
        });
    }
};
