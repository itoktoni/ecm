<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('so', function (Blueprint $table) {
            $table->string('so_pph', 20)->default('no')->after('so_status');
            $table->integer('so_pph_rate')->default(2)->after('so_pph');
            $table->string('so_ppn', 20)->default('none')->after('so_pph_rate');
            $table->integer('so_ppn_rate')->default(11)->after('so_ppn');
            $table->decimal('so_discount', 15, 2)->default(0)->after('so_ppn_rate');
            $table->string('so_discount_note', 255)->nullable()->after('so_discount');
        });
    }

    public function down(): void
    {
        Schema::table('so', function (Blueprint $table) {
            $table->dropColumn(['so_pph', 'so_pph_rate', 'so_ppn', 'so_ppn_rate', 'so_discount', 'so_discount_note']);
        });
    }
};
