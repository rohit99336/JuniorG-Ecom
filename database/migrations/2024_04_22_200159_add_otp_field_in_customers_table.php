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
            // add the otp after phone2
            $table->string('otp')->nullable()->after('phone2');

            // otp_verified_at after otp
            $table->timestamp('otp_verified_at')->nullable()->after('otp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // remove the otp after phone2
            $table->dropColumn('otp');

            // otp_verified_at after otp
            $table->dropColumn('otp_verified_at');
        });
    }
};
