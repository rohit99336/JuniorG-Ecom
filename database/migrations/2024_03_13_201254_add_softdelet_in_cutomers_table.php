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
            // add soft deletes
            $table->softDeletes();

            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('ecom_admins')->onDelete('set null');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('ecom_admins')->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('ecom_admins')->onDelete('set null');

            $table->unsignedBigInteger('restored_by')->nullable();
            $table->foreign('restored_by')->references('id')->on('ecom_admins')->onDelete('set null');

            $table->unsignedBigInteger('force_deleted_by')->nullable();
            $table->foreign('force_deleted_by')->references('id')->on('ecom_admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropSoftDeletes();

            $table->dropForeign(['deleted_by']);
            $table->dropColumn('deleted_by');

            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');

            $table->dropForeign(['updated_by']);
            $table->dropColumn('updated_by');

            $table->dropForeign(['restored_by']);
            $table->dropColumn('restored_by');

            $table->dropForeign(['force_deleted_by']);
            $table->dropColumn('force_deleted_by');
        });
    }
};
