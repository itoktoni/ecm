<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_so', function (Blueprint $table) {
            $table->foreignId('so_detail_id_teknisi')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->string('so_detail_kerja_status', 20)->default('Tersedia');
            $table->timestamp('so_detail_kerja_ambil_at')->nullable();
            $table->timestamp('so_detail_kerja_selesai_at')->nullable();
            $table->json('so_detail_lembar')->nullable();
            $table->string('so_detail_sertifikat_no', 60)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('detail_so', function (Blueprint $table) {
            $table->dropConstrainedForeignId('so_detail_id_teknisi');
            $table->dropColumn([
                'so_detail_kerja_status',
                'so_detail_kerja_ambil_at',
                'so_detail_kerja_selesai_at',
                'so_detail_lembar',
                'so_detail_sertifikat_no',
            ]);
        });
    }
};
