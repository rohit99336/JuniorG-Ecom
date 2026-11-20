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
        Schema::table('roles', function (Blueprint $table) {
            // // add created by and updated by
            // $table->unsignedBigInteger('created_by')->nullable();
            // $table->unsignedBigInteger('updated_by')->nullable();

            //  $table->foreign('created_by')->references('id')->on('ecom_admins')->onDelete();
            //  $table->foreign('updated_by')->references('id')->on('ecom_admins');

            $table->foreignId('created_by')->nullable()->constrained('ecom_admins')->cascadeOnDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('ecom_admins')->cascadeOnDelete('set null');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('ecom_admins')->cascadeOnDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('ecom_admins')->cascadeOnDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by']);
            $table->dropColumn(['updated_by']);

        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by']);
            $table->dropColumn(['updated_by']);

        });
    }
};
