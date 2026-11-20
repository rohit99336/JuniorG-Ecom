<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('approved_by')->nullable()->comment('ID of the user who approved the post');
            $table->string('title');
            $table->longText('body');
            $table->integer('views')->default(0)->unsigned()->comment('Number of views');
            $table->integer('likes')->default(0)->unsigned()->comment('Number of likes');
            $table->integer('dislikes')->default(0)->unsigned()->comment('Number of dislikes');
            $table->string('thumbnail')->nullable()->comment('Thumbnail image path');
            $table->boolean('is_published')->default(false)->comment('Whether the post is published or not');
            $table->enum('status', ['pending', 'approved', 'blocked', 'released'])->default('pending')->comment('Post status');
            $table->dateTime('approve_at')->nullable()->comment('Date and time when the post was approved');
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('ecom_admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
