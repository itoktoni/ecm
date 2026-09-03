<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Gudang;
use App\Models\Jasa;
use App\Models\Lokasi;
use Illuminate\Database\Seeder;

/**
 * Data pendukung untuk perusahaan jasa kalibrasi & perawatan alat kesehatan.
 *
 * - jasa: Kalibrasi, Maintenance, Perbaikan (di-filter di form SO)
 * - gudang + lokasi untuk kelola stock
 * - customer: rumah sakit / klinik / puskesmas / lab
 *
 * Catatan: seeder ini TIDAK lagi membuat product / so demo. Daftar produk
 * kalibrasi sepenuhnya diambil dari seeder PriceListKalibrasiSeeder
 * (bersumber dari docs/Price List Umum.pdf).
 */
class KalibrasiAlkesSeeder extends Seeder
{
    public function run(): void
    {
        if (Jasa::count() > 0) {
            return;
        }

        Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
        Jasa::create(['jasa_nama' => 'Maintenance', 'jasa_icon' => 'handyman']);
        Jasa::create(['jasa_nama' => 'Perbaikan', 'jasa_icon' => 'build']);

        $gudang = Gudang::create(['gudang_nama' => 'Gudang Alkes']);
        Lokasi::create(['lokasi_nama' => 'Rak Kalibrasi', 'lokasi_id_gudang' => $gudang->gudang_id]);

        // --- Customer ---
        Customer::create([
            'customer_nama' => 'RSUD dr. Soetomo',
            'customer_telepon' => '031-5501000',
            'customer_alamat' => 'Jl. Mayjen Prof. Dr. Moestopo 6-8, Surabaya',
        ]);
        Customer::create([
            'customer_nama' => 'RS Siloam Hospitals',
            'customer_telepon' => '021-80650000',
            'customer_alamat' => 'Jl. Boulevard Timur, Kelapa Gading, Jakarta Utara',
        ]);
        Customer::create([
            'customer_nama' => 'Klinik Sehat Medika',
            'customer_telepon' => '022-7306000',
            'customer_alamat' => 'Jl. Asia Afrika 20, Bandung',
        ]);
        Customer::create([
            'customer_nama' => 'Puskesmas Sukamaju',
            'customer_telepon' => '0341-330001',
            'customer_alamat' => 'Jl. Raya Sukamaju 12, Malang',
        ]);
        Customer::create([
            'customer_nama' => 'Lab Klinik Prodia',
            'customer_telepon' => '031-5022444',
            'customer_alamat' => 'Jl. Basuki Rahmat 25, Surabaya',
        ]);
    }
}