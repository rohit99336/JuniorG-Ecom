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
        Schema::table('product_variants', function (Blueprint $table) {
            // add original price if not exists
            if (!Schema::hasColumn('product_variants', 'org_price')) {
                $table->decimal('org_price', 10, 2)->nullable()->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // drop column if exists
            if (Schema::hasColumn('product_variants', 'org_price')) {
                $table->dropColumn('org_price ');
            }
        });
    }
};
