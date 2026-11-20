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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->string('thumbnail_img')->nullable();
            $table->longText('content');
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->json('tag')->nullable();

            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');  //cascade means if a category is deleted, all the blogs associated with that category will be deleted too.
            $table->foreign('created_by')->references('id')->on('ecom_admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
