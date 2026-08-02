<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('type')->nullable();
            $table->json('config')->nullable();
            $table->json('rules')->nullable();
            $table->boolean('is_required')->nullable()->default(0);
            $table->text('default_value')->nullable();
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('mode')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->boolean('collapsed')->nullable();
            $table->boolean('sortable')->nullable();
            $table->boolean('cloneable')->nullable();
            $table->json('layouts')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('fields')->nullOnDelete();
            $table->foreign('type_id')->references('id')->on('types')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
