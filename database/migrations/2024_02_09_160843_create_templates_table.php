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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('msg_temp_id')->nullable();
            $table->string('subject')->nullable();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->text('message')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('event_name')->nullable();
            $table->text('media_file')->nullable();
            $table->enum('for', ['salon', 'ecom'])->default('salon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
