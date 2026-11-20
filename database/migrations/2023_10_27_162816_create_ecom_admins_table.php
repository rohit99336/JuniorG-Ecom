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
        Schema::create('ecom_admins', function (Blueprint $table) {
            $table->id();
            $table->string('section')->default('ecom');
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->nullable()->comment('profile picture');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->integer('pincode_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecom_admins');
    }
};
