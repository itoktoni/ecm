<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Gudang;
use App\Models\Jasa;
use App\Models\Lokasi;
use App\Models\Product;
use App\Models\So;
use App\Models\SoDetail;
use App\Models\Stock;
use Illuminate\Database\Seeder;

/**
 * Demo data untuk perusahaan jasa kalibrasi & perawatan alat kesehatan.
 *
 * - jasa: Kalibrasi, Maintenance, Perbaikan (di-filter di form SO)
 * - product = alat kesehatan; kalibrasi & maintenance punya harga tetap,
 *   perbaikan punya harga NULL (diisi manual di form SO)
 * - customer: rumah sakit / klinik / puskesmas / lab
 * - so: contoh sales order dengan PPN/PPH/discount
 */
class KalibrasiAlkesSeeder extends Seeder
{
    public function run(): void
    {
        if (Jasa::count() > 0) {
            return;
        }

        $kalibrasi = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
        $maintenance = Jasa::create(['jasa_nama' => 'Maintenance', 'jasa_icon' => 'handyman']);
        $perbaikan = Jasa::create(['jasa_nama' => 'Perbaikan', 'jasa_icon' => 'build']);

        $gudang = Gudang::create(['gudang_nama' => 'Gudang Alkes']);
        $lokasi = Lokasi::create(['lokasi_nama' => 'Rak Kalibrasi', 'lokasi_id_gudang' => $gudang->gudang_id]);

        $alat = function (string $nama, Jasa $jasa, ?float $harga = null) use ($lokasi): Product {
            $p = Product::create([
                'product_nama' => $nama,
                'product_id_jasa' => $jasa->jasa_id,
                'product_harga' => $harga,
            ]);

            Stock::create([
                'stock_code' => 'STK-ALK-'.str_pad((string) $p->product_id, 3, '0', STR_PAD_LEFT),
                'stock_id_product' => $p->product_id,
                'stock_id_lokasi' => $lokasi->lokasi_id,
                'stock_qty' => 10,
                'stock_type' => 'IN',
            ]);

            return $p;
        };

        // --- Kalibrasi (harga tetap per alat) ---
        $kalEcg = $alat('Kalibrasi ECG Monitor', $kalibrasi, 1000000);
        $kalInfusion = $alat('Kalibrasi Infusion Pump', $kalibrasi, 850000);
        $kalVentilator = $alat('Kalibrasi Ventilator', $kalibrasi, 1200000);
        $kalAutoclave = $alat('Kalibrasi Autoclave', $kalibrasi, 750000);
        $kalDefibrillator = $alat('Kalibrasi Defibrillator', $kalibrasi, 1100000);
        $kalBpap = $alat('Kalibrasi B-PAP', $kalibrasi, 950000);

        // --- Maintenance (harga per bulan) ---
        $mtEcg = $alat('Maintenance ECG Monitor', $maintenance, 500000);
        $mtInfusion = $alat('Maintenance Infusion Pump', $maintenance, 450000);
        $mtVentilator = $alat('Maintenance Ventilator', $maintenance, 600000);

        // --- Perbaikan (harga NULL, diisi manual di form SO) ---
        $prEcg = $alat('Perbaikan ECG Monitor', $perbaikan, null);
        $prInfusion = $alat('Perbaikan Infusion Pump', $perbaikan, null);
        $prAutoclave = $alat('Perbaikan Autoclave', $perbaikan, null);

        // --- Customer ---
        $rsud = Customer::create([
            'customer_nama' => 'RSUD dr. Soetomo',
            'customer_telepon' => '031-5501000',
            'customer_alamat' => 'Jl. Mayjen Prof. Dr. Moestopo 6-8, Surabaya',
        ]);
        $siloam = Customer::create([
            'customer_nama' => 'RS Siloam Hospitals',
            'customer_telepon' => '021-80650000',
            'customer_alamat' => 'Jl. Boulevard Timur, Kelapa Gading, Jakarta Utara',
        ]);
        $klinik = Customer::create([
            'customer_nama' => 'Klinik Sehat Medika',
            'customer_telepon' => '022-7306000',
            'customer_alamat' => 'Jl. Asia Afrika 20, Bandung',
        ]);
        $puskesmas = Customer::create([
            'customer_nama' => 'Puskesmas Sukamaju',
            'customer_telepon' => '0341-330001',
            'customer_alamat' => 'Jl. Raya Sukamaju 12, Malang',
        ]);
        $lab = Customer::create([
            'customer_nama' => 'Lab Klinik Prodia',
            'customer_telepon' => '031-5022444',
            'customer_alamat' => 'Jl. Basuki Rahmat 25, Surabaya',
        ]);

        // --- Sales Order ---
        $this->createSo($rsud, 'Pending', 'none', 11, 'exclude', 2, 100000, 'Paket langganan kalibrasi',
            'Diskon langganan tahunan', 'Sertifikat kalibrasi menyusul setelah QC',
            [[$kalEcg, 2], [$mtEcg, 1]]);

        $this->createSo($siloam, 'Confirmed', 'exclude', 11, 'exclude', 2, 0, 'Penawaran kalibrasi + perbaikan',
            null, 'Termasuk biaya penggantian part',
            [[$kalVentilator, 1], [$prInfusion, 1, 900000]]);

        $this->createSo($klinik, 'Pending', 'include', 11, 'no', 2, 250000, 'Maintenance berkala',
            'Diskon promo akhir bulan', 'QC report dikirim via email',
            [[$mtVentilator, 1], [$kalAutoclave, 2]]);

        $this->createSo($puskesmas, 'Closed', 'none', 11, 'no', 2, 0, null,
            null, null,
            [[$kalInfusion, 1], [$prEcg, 1, 1250000]]);

        $this->createSo($lab, 'Shipped', 'exclude', 11, 'exclude', 2, 150000, 'Kalibrasi tahunan alat lab',
            'Paket korporasi multi alat', 'Prioritas antrian 3 hari kerja',
            [[$kalDefibrillator, 1], [$kalBpap, 1], [$mtInfusion, 2]]);
    }

    private function createSo(Customer $customer, string $status, string $ppn, int $ppnRate, string $pph, int $pphRate, float $discount, ?string $note, ?string $discountNote, ?string $detailNote, array $lines): void
    {
        $so = So::create([
            'so_tanggal' => now()->toDateString(),
            'so_id_customer' => $customer->customer_id,
            'so_status' => $status,
            'so_keterangan' => $note,
            'so_ppn' => $ppn,
            'so_ppn_rate' => $ppnRate,
            'so_pph' => $pph,
            'so_pph_rate' => $pphRate,
            'so_discount' => $discount,
            'so_discount_note' => $discountNote,
        ]);

        $seq = 1;
        foreach ($lines as $line) {
            [$product, $qty] = $line;
            $harga = $line[2] ?? null;
            SoDetail::create([
                'so_detail_id_so' => $so->so_id,
                'so_detail_id_product' => $product->product_id,
                'so_detail_qty' => $qty,
                'so_detail_harga' => $harga ?? $product->product_harga,
                'so_detail_keterangan' => $detailNote,
                'so_detail_code' => sprintf('%s-%03d', $so->so_code, $seq),
            ]);
            $seq++;
        }
    }
}
