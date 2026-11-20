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
        Schema::table('customers', function (Blueprint $table) {
            // add gender column
            $table->enum('gender', ['male', 'female', 'other'])->default('male')->after('last_name');
            $table->unsignedBigInteger('default_address_id')->nullable()->after('gender');
            $table->foreign('default_address_id')->references('id')->on('addresses')->onDelete('set null');
            $table->date('dob')->nullable()->after('default_address_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropForeign(['default_address_id']);
            $table->dropColumn('default_address_id');
            $table->dropColumn('dob');
        });
    }
};
