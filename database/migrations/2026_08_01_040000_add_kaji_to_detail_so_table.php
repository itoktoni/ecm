<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_so', function (Blueprint $table) {
            $table->boolean('so_detail_kaji_a')->default(false);
            $table->boolean('so_detail_kaji_b')->default(false);
            $table->boolean('so_detail_kaji_c')->default(false);
            $table->boolean('so_detail_kaji_d')->default(false);
            $table->text('so_detail_kaji_keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('detail_so', function (Blueprint $table) {
            $table->dropColumn([
                'so_detail_kaji_a',
                'so_detail_kaji_b',
                'so_detail_kaji_c',
                'so_detail_kaji_d',
                'so_detail_kaji_keterangan',
            ]);
        });
    }
};
