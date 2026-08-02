<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('so_petugas', function (Blueprint $table) {
            $table->id('so_petugas_id');
            $table->foreignId('so_petugas_id_so')->constrained('so', 'so_id')->cascadeOnDelete();
            $table->foreignId('so_petugas_id_user')->constrained('users', 'id')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['so_petugas_id_so', 'so_petugas_id_user']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('so_petugas');
    }
};
