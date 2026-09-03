<?php

namespace Database\Seeders;

use App\Models\Jasa;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Seed daftar alat kalibrasi beserta harga & link E-Katalog.
 *
 * Sumber data: docs/Price List Umum.pdf (Harga Katalog Kalibrasi 2025,
 * Ed. 3, Rev. 0 / Tgl Ed. 18-02-25) — total 252 alat.
 *
 * Setiap produk dibuat/update berdasarkan kombinasi (nama + jasa Kalibrasi)
 * sehingga seeder bersifat idempotent dan tidak menghasilkan duplikat.
 */
class PriceListKalibrasiSeeder extends Seeder
{
    public function run(): void
    {
        $items = require __DIR__.'/data/price_list_umum.php';

        $kalibrasi = Jasa::firstOrCreate(
            ['jasa_nama' => 'Kalibrasi'],
            ['jasa_icon' => 'straighten']
        );

        foreach ($items as $item) {
            Product::updateOrCreate(
                [
                    'product_nama' => $item['nama'],
                    'product_id_jasa' => $kalibrasi->jasa_id,
                ],
                [
                    'product_harga' => $item['harga'],
                    'product_ekatalog' => $item['ekatalog'],
                ]
            );
        }
    }
}