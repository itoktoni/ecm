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

function printActor(): User
{
    return User::create(['name' => 'T', 'email' => 'print-'.uniqid().'@t.com', 'password' => bcrypt('x'), 'role' => 'admin']);
}

function printSo(): So
{
    $jasa = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'x']);
    $customer = Customer::create(['customer_nama' => 'C']);
    $product = Product::create(['product_nama' => 'P', 'product_id_jasa' => $jasa->jasa_id, 'product_harga' => 1000]);
    $gudang = Gudang::create(['gudang_nama' => 'G']);
    $lokasi = Lokasi::create(['lokasi_nama' => 'L', 'lokasi_id_gudang' => $gudang->gudang_id]);
    Stock::create(['stock_code' => 'S-'.uniqid(), 'stock_id_product' => $product->product_id, 'stock_id_lokasi' => $lokasi->lokasi_id, 'stock_qty' => 10, 'stock_type' => 'IN']);

    $so = So::create([
        'so_tanggal' => '2026-08-01',
        'so_id_customer' => $customer->customer_id,
        'so_status' => 'Confirmed',
        'so_pph' => 'no',
        'so_pph_rate' => 2,
        'so_ppn' => 'none',
        'so_ppn_rate' => 11,
        'so_discount' => 0,
        'so_keterangan' => 'Rusak ringan',
    ]);
    SoDetail::create([
        'so_detail_id_so' => $so->so_id,
        'so_detail_id_product' => $product->product_id,
        'so_detail_qty' => 2,
        'so_detail_harga' => 1000,
        'so_detail_code' => $so->so_code.'-001',
    ]);

    return $so;
}

it('streams an SO as pdf on the print route', function () {
    $this->actingAs(printActor());
    $so = printSo();

    $r = $this->get('/wms/so/print/'.$so->so_id);

    $r->assertStatus(200);
    expect($r->headers->get('content-type'))->toContain('application/pdf');
    expect($r->headers->get('content-disposition'))->toContain('inline');
    expect($r->getContent())->toContain('%PDF');
});

it('404s the print route for missing so', function () {
    $this->actingAs(printActor());

    $this->get('/wms/so/print/9999')->assertStatus(404);
});

it('streams a penawaran as pdf', function () {
    $this->actingAs(printActor());
    $so = printSo();

    $r = $this->get('/wms/so/penawaran/'.$so->so_id);

    $r->assertStatus(200);
    expect($r->headers->get('content-type'))->toContain('application/pdf');
    expect($r->headers->get('content-disposition'))->toContain('inline');
    expect($r->getContent())->toContain('%PDF');
});

it('streams a surat tugas as pdf with assigned petugas', function () {
    $this->actingAs(printActor());
    $so = printSo();
    $tech = User::create(['name' => 'Teknisi A', 'email' => 'tech-'.uniqid().'@t.com', 'password' => bcrypt('x'), 'role' => 'user']);
    $so->petugas()->sync([$tech->id]);

    $r = $this->get('/wms/so/surat-tugas/'.$so->so_id);

    $r->assertStatus(200);
    expect($r->headers->get('content-type'))->toContain('application/pdf');
    expect($r->getContent())->toContain('%PDF');
});

it('renders the kaji ulang page with items', function () {
    $this->actingAs(printActor());
    $so = printSo();

    $r = $this->get('/wms/so/kaji-ulang/'.$so->so_id);

    $r->assertStatus(200);
    expect($r->getContent())->toContain('Form Kaji Ulang');
});

it('renders the print button on the edit form', function () {
    $this->actingAs(printActor());
    $so = printSo();

    $r = $this->get('/wms/so/update/'.$so->so_id);

    $r->assertStatus(200);
    $html = $r->getContent();
    expect($html)->toContain('href="http://lms.test/wms/so/print/'.$so->so_id.'"');
    expect($html)->toContain('>Print</span>');
});

it('renders the print button on the table page', function () {
    $this->actingAs(printActor());
    $so = printSo();

    $r = $this->get('/wms/so/table');

    $r->assertStatus(200);
    $html = $r->getContent();
    expect($html)->toContain('href="http://lms.test/wms/so/print/'.$so->so_id.'"');
    expect($html)->toContain('>print</span>');
    expect($html)->toContain('href="http://lms.test/wms/so/penawaran/'.$so->so_id.'"');
    expect($html)->toContain('>request_quote</span>');
    expect($html)->toContain('href="http://lms.test/wms/so/surat-tugas/'.$so->so_id.'"');
    expect($html)->toContain('>assignment_ind</span>');
    expect($html)->toContain('href="http://lms.test/wms/so/kaji-ulang/'.$so->so_id.'"');
    expect($html)->toContain('>fact_check</span>');
});

it('saves kaji ulang checklist and keterangan', function () {
    $this->actingAs(printActor());
    $so = printSo();
    $detailId = $so->details->first()->so_detail_id;

    Livewire\Livewire::test('so-kaji-ulang', ['soId' => $so->so_id])
        ->set('rows.0.a', true)
        ->set('rows.0.c', true)
        ->set('rows.0.keterangan', 'subkontrak ke PT. A')
        ->call('save')
        ->assertSet('saved', true);

    $d = SoDetail::find($detailId);
    expect($d->so_detail_kaji_a)->toBeTrue();
    expect($d->so_detail_kaji_b)->toBeFalse();
    expect($d->so_detail_kaji_c)->toBeTrue();
    expect($d->so_detail_kaji_keterangan)->toBe('subkontrak ke PT. A');
});

it('persists petugas on so update', function () {
    $this->actingAs(printActor());
    $so = printSo();
    $tech = User::create(['name' => 'Teknisi B', 'email' => 'techb-'.uniqid().'@t.com', 'password' => bcrypt('x'), 'role' => 'user']);

    $payload = [
        'so_tanggal' => '2026-08-01',
        'so_id_customer' => $so->so_id_customer,
        'so_pph' => 'no', 'so_pph_rate' => 2,
        'so_ppn' => 'none', 'so_ppn_rate' => 11,
        'so_discount' => 0,
        'details' => [[
            'so_detail_id' => null,
            'so_detail_id_product' => $so->details->first()->so_detail_id_product,
            'so_detail_qty' => 1,
            'so_detail_harga' => 1000,
        ]],
        'petugas' => [$tech->id],
    ];

    $this->post('/wms/so/update/'.$so->so_id, $payload)->assertStatus(302);

    expect($so->fresh()->petugas->pluck('id')->all())->toBe([$tech->id]);
});
