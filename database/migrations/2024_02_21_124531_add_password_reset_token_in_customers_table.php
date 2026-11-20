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
            // add password reset token
            $table->string('password_reset_token')->nullable()->after('password');

            // add password_reset_at
            $table->timestamp('password_reset_at')->nullable()->after('password_reset_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // drop password reset token
            $table->dropColumn('password_reset_token');

            // drop password_reset_at
            $table->dropColumn('password_reset_at');
        });
    }
};
