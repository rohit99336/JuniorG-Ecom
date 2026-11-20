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
        Schema::table('ecom_admins', function (Blueprint $table) {
            // addd emplyee id field
            $table->string('employee_id')->after('password')->nullable();

            // add created_by foreign key
            $table->unsignedBigInteger('created_by')->after('remember_token')->nullable();
            $table->foreign('created_by')->references('id')->on('ecom_admins')->onDelete('set null');

            // add updated_by foreign key
            $table->unsignedBigInteger('updated_by')->after('created_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('ecom_admins')->onDelete('set null');

            // add deleted_by foreign key
            $table->unsignedBigInteger('deleted_by')->after('updated_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('ecom_admins')->onDelete('set null');

            // add soft delete column
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecom_admins', function (Blueprint $table) {
            // remove employee_id field
            $table->dropColumn('employee_id');

            // remove created_by foreign key
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');

            // remove updated_by foreign key
            $table->dropForeign(['updated_by']);
            $table->dropColumn('updated_by');

            // remove deleted_by foreign key
            $table->dropForeign(['deleted_by']);
            $table->dropColumn('deleted_by');

            // remove soft delete column
            $table->dropSoftDeletes();
        });
    }
};
