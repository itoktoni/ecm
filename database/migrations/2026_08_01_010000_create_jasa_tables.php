<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jasa', function (Blueprint $table) {
            $table->id('jasa_id');
            $table->string('jasa_nama', 100)->unique();
            $table->string('jasa_icon', 50)->nullable();
            $table->timestamps();
        });

        Schema::table('product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id_jasa')->nullable()->after('product_nama');
            $table->foreign('product_id_jasa')->references('jasa_id')->on('jasa')->onDelete('set null');
            $table->decimal('product_harga', 15, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign(['product_id_jasa']);
            $table->dropColumn('product_id_jasa');
        });

        Schema::dropIfExists('jasa');
    }
};
