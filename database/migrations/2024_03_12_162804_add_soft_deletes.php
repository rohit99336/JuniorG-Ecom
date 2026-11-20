<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {

    //     Schema::table('orders', function (Blueprint $table) {
    //         // Add soft deletes
    //         $table->softDeletes();

    //         // add deletd_by column
    //         $table->unsignedBigInteger('deleted_by')->nullable();
    //         $table->foreign('deleted_by')->references('id')->on('ecom_admins')->onDelete('set null');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('orders', function (Blueprint $table) {
    //         $table->dropSoftDeletes();

    //         $table->dropForeign(['deleted_by']);
    //         $table->dropColumn('deleted_by');

    //     });
    // }
};
