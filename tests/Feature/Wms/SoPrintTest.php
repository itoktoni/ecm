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
});
