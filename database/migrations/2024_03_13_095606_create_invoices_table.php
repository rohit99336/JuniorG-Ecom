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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->string('payment_method');
            $table->string('transaction_id');
            $table->string('status');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('payment_status');
            $table->json('payment_response');
            $table->dateTime('payment_date');
            $table->dateTime('payment_expiry');
            $table->string('payment_type');
            $table->string('payment_mode');
            $table->string('bank');
            $table->string('card_no');
            $table->string('card_type');
            $table->string('card_expiry_month');
            $table->string('card_expiry_year');
            $table->string('card_cvv');
            $table->string('card_holder_name');
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained('ecom_admins')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('ecom_admins')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('ecom_admins')->onDelete('set null');
            $table->foreignId('restored_by')->nullable()->constrained('ecom_admins')->onDelete('set null');
            $table->foreignId('force_deleted_by')->nullable()->constrained('ecom_admins')->onDelete('set null');
            $table->timestamps();

            $table->unique('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
