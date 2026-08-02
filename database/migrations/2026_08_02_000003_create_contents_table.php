<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_type_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->longText('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('featured_image')->nullable();
            $table->integer('menu_order')->default(0);
            $table->json('meta')->nullable();
            $table->json('active_sections')->nullable();
            $table->json('category_ids')->nullable();
            $table->json('tag_ids')->nullable();
            $table->timestamps();

            $table->foreign('content_type_id')->references('id')->on('types')->nullOnDelete();
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
