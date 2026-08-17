<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
                // Tabel pesanan (orders) — mirip tabel so, khusus ecommerce frontend
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('order_no')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('customer_nama', 150)->nullable();
            $table->string('customer_email', 150)->nullable();
            $table->string('customer_telepon', 50)->nullable();
            $table->string('customer_alamat', 250)->nullable();
            $table->decimal('order_subtotal', 15, 2)->default(0);
                        $table->decimal('order_tax', 15, 2)->default(0);
            $table->decimal('order_discount', 15, 2)->default(0);
            $table->decimal('order_total', 15, 2)->default(0);
            $table->string('order_status', 20)->default('draft');
            $table->date('order_tanggal')->nullable();
            $table->date('order_tanggal_kirim')->nullable();
            $table->string('order_catatan', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        // Tabel detail pesanan
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_nama', 150);
            $table->decimal('product_harga', 15, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders')->cascadeOnDelete();
            $table->foreign('product_id')->references('product_id')->on('product')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
