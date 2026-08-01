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

it('renders selected status option on edit form', function () {
    $user = User::create(['name' => 'T', 'email' => 't-'.uniqid().'@t.com', 'password' => bcrypt('x'), 'role' => 'admin']);
    $this->actingAs($user);

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
    ]);
    SoDetail::create([
        'so_detail_id_so' => $so->so_id,
        'so_detail_id_product' => $product->product_id,
        'so_detail_qty' => 1,
        'so_detail_harga' => 1000,
        'so_detail_code' => $so->so_code.'-001',
    ]);

    $r = $this->get('/wms/so/update/'.$so->so_id);
    $r->assertStatus(200);
    $html = $r->getContent();
    file_put_contents(base_path('tests/dump_so_edit.html'), $html);

    expect($html)->toContain('name="so_status"');
    expect($html)->toMatch('/value="Confirmed"\s+selected\s*>/');
    expect($html)->toMatch('/<option value="Pending"\s*>/');
});

it('updates so without clearing status when status select is empty', function () {
    $user = User::create(['name' => 'T', 'email' => 't2-'.uniqid().'@t.com', 'password' => bcrypt('x'), 'role' => 'admin']);
    $this->actingAs($user);

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
    ]);
    SoDetail::create([
        'so_detail_id_so' => $so->so_id,
        'so_detail_id_product' => $product->product_id,
        'so_detail_qty' => 1,
        'so_detail_harga' => 1000,
        'so_detail_code' => $so->so_code.'-001',
    ]);

    $payload = [
        'so_tanggal' => '2026-08-01',
        'so_id_customer' => $customer->customer_id,
        'so_pph' => 'include',
        'so_pph_rate' => 2,
        'so_ppn' => 'exclude',
        'so_ppn_rate' => 11,
        'so_discount' => 1000000,
        'so_discount_note' => 'pembelian diatas 100juta discount 20%',
        'details' => [
            [
                'so_detail_id' => null,
                'so_detail_id_product' => $product->product_id,
                'so_detail_qty' => 1,
                'so_detail_harga' => 1000,
            ],
        ],
    ];

    $r = $this->post('/wms/so/update/'.$so->so_id, $payload);
    $r->assertStatus(302);

    $so->refresh();
    expect($so->so_status)->toBe('Confirmed');
});
