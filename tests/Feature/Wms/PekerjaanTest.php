<?php

use App\Models\Customer;
use App\Models\Gudang;
use App\Models\Jasa;
use App\Models\Lokasi;
use App\Models\Product;
use App\Models\So;
use App\Models\SoDetail;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function makeTech(string $tag): User
{
    return User::create(['name' => 'Tek '.$tag, 'email' => $tag.'-'.uniqid().'@t.com', 'password' => bcrypt('x'), 'role' => 'user']);
}

function soWithLines(array $techIds = []): So
{
    $jasa = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'x']);
    $customer = Customer::create(['customer_nama' => 'RS X', 'customer_alamat' => 'Jl Y']);
    $gudang = Gudang::create(['gudang_nama' => 'G']);
    $lokasi = Lokasi::create(['lokasi_nama' => 'L', 'lokasi_id_gudang' => $gudang->gudang_id]);

    $so = So::create([
        'so_tanggal' => '2026-08-01', 'so_id_customer' => $customer->customer_id, 'so_status' => 'Confirmed',
        'so_pph' => 'no', 'so_pph_rate' => 2, 'so_ppn' => 'none', 'so_ppn_rate' => 11, 'so_discount' => 0,
    ]);

    foreach (['A', 'B'] as $n => $name) {
        $p = Product::create(['product_nama' => 'Prod '.$name, 'product_id_jasa' => $jasa->jasa_id, 'product_harga' => 1000]);
        Stock::create(['stock_code' => 'S-'.uniqid(), 'stock_id_product' => $p->product_id, 'stock_id_lokasi' => $lokasi->lokasi_id, 'stock_qty' => 10, 'stock_type' => 'IN']);
        SoDetail::create([
            'so_detail_id_so' => $so->so_id, 'so_detail_id_product' => $p->product_id,
            'so_detail_qty' => 1, 'so_detail_harga' => 1000, 'so_detail_code' => $so->so_code.'-00'.($n + 1),
        ]);
    }

    if ($techIds) {
        $so->petugas()->sync($techIds);
    }

    return $so;
}

it('shows only lines from SO where the user is a petugas', function () {
    $tech = makeTech('t1');
    $other = makeTech('t2');
    $so = soWithLines([$tech->id]);

    $this->actingAs($tech);
    $r = $this->get('/wms/pekerjaan/table');
    $r->assertStatus(200);
    expect($r->getContent())->toContain($so->so_code);

    $this->actingAs($other);
    $r2 = $this->get('/wms/pekerjaan/table');
    expect($r2->getContent())->not->toContain($so->so_code);
});

it('lets an assigned technician claim a free line', function () {
    $tech = makeTech('t1');
    $so = soWithLines([$tech->id]);
    $line = $so->details->first();

    $this->actingAs($tech);
    $this->get('/wms/pekerjaan/ambil/'.$line->so_detail_id)->assertRedirect();

    $line->refresh();
    expect($line->so_detail_kerja_status)->toBe('Diambil');
    expect((int) $line->so_detail_id_teknisi)->toBe($tech->id);
});

it('prevents a second technician from claiming a taken line', function () {
    $t1 = makeTech('t1');
    $t2 = makeTech('t2');
    $so = soWithLines([$t1->id, $t2->id]);
    $line = $so->details->first();

    $this->actingAs($t1);
    $this->get('/wms/pekerjaan/ambil/'.$line->so_detail_id);

    $this->actingAs($t2);
    $this->get('/wms/pekerjaan/ambil/'.$line->so_detail_id)->assertRedirect();

    expect((int) $line->fresh()->so_detail_id_teknisi)->toBe($t1->id);
});

it('saves the lembar kerja and completes the job with a certificate number', function () {
    $tech = makeTech('t1');
    $so = soWithLines([$tech->id]);
    $line = $so->details->first();

    $this->actingAs($tech);
    $this->get('/wms/pekerjaan/ambil/'.$line->so_detail_id);

    $this->post('/wms/pekerjaan/lembar/'.$line->so_detail_id, [
        'lembar' => ['merek' => 'GE', 'tipe' => 'X100', 'penilaian' => 'Baik digunakan'],
        'selesai' => 1,
    ])->assertRedirect();

    $line->refresh();
    expect($line->so_detail_kerja_status)->toBe('Selesai');
    expect($line->so_detail_lembar['merek'])->toBe('GE');
    expect($line->so_detail_sertifikat_no)->not->toBeNull();
});

it('streams berita acara pdf for a completed job', function () {
    $tech = makeTech('t1');
    $so = soWithLines([$tech->id]);
    $line = $so->details->first();
    $line->update([
        'so_detail_id_teknisi' => $tech->id,
        'so_detail_kerja_status' => 'Selesai',
        'so_detail_sertifikat_no' => 'BA-TEST-0001',
        'so_detail_lembar' => ['penilaian' => 'Baik digunakan'],
    ]);

    $this->actingAs($tech);
    $r = $this->get('/wms/pekerjaan/berita-acara/'.$line->so_detail_id);
    $r->assertStatus(200);
    expect($r->headers->get('content-type'))->toContain('application/pdf');
    expect($r->getContent())->toContain('%PDF');
});

it('streams sertifikat pdf for a completed job', function () {
    $tech = makeTech('t1');
    $so = soWithLines([$tech->id]);
    $line = $so->details->first();
    $line->update([
        'so_detail_id_teknisi' => $tech->id,
        'so_detail_kerja_status' => 'Selesai',
        'so_detail_kerja_selesai_at' => now(),
        'so_detail_sertifikat_no' => 'BA-TEST-0001',
        'so_detail_lembar' => ['penilaian' => 'Baik digunakan', 'merek' => 'GE'],
    ]);

    $this->actingAs($tech);
    $r = $this->get('/wms/pekerjaan/sertifikat/'.$line->so_detail_id);
    $r->assertStatus(200);
    expect($r->headers->get('content-type'))->toContain('application/pdf');
    expect($r->getContent())->toContain('%PDF');
});
