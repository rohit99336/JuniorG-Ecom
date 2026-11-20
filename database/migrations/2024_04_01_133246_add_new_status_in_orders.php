<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // add new options in status enum  field
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'placed', 'processing', 'shipped','completed','declined','refunded','cancelled','failed')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //  remove "pending_payment" from status enum
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('placed', 'processing', 'shipped', 'completed', 'declined', 'refunded', 'cancelled', 'failed')");
        });
    }
};
