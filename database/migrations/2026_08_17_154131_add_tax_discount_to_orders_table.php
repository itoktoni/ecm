<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_ppn', 10)->default('none')->after('order_tax');
            $table->integer('order_ppn_rate')->default(11)->after('order_ppn');
            $table->decimal('order_ppn_amount', 15, 2)->default(0)->after('order_ppn_rate');
            $table->string('order_pph', 10)->default('no')->after('order_ppn_amount');
            $table->integer('order_pph_rate')->default(2)->after('order_pph');
            $table->decimal('order_pph_amount', 15, 2)->default(0)->after('order_pph_rate');
            $table->string('order_discount_note', 255)->nullable()->after('order_discount');
        });
    }
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_ppn', 'order_ppn_rate', 'order_ppn_amount', 'order_pph', 'order_pph_rate', 'order_pph_amount', 'order_discount_note']);
        });
    }
};
