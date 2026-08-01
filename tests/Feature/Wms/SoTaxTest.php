<?php

use App\Models\Customer;
use App\Models\Gudang;
use App\Models\Lokasi;
use App\Models\Product;
use App\Models\So;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::create([
        'name' => 'Test Admin',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);
    $this->actingAs($this->user);

    $gudang = Gudang::create(['gudang_nama' => 'Gudang A']);
    $lokasi = Lokasi::create(['lokasi_nama' => 'Lokasi A', 'lokasi_id_gudang' => $gudang->gudang_id]);
    $this->customer = Customer::create([
        'customer_nama' => 'PT Maju',
        'customer_telepon' => '0812',
        'customer_alamat' => 'Jakarta',
    ]);
    $this->product = Product::create([
        'product_nama' => 'Daging Sapi (kg)',
        'product_harga' => 135000,
    ]);
    Stock::create([
        'stock_code' => 'STK-001',
        'stock_id_product' => $this->product->product_id,
        'stock_id_lokasi' => $lokasi->lokasi_id,
        'stock_qty' => 100,
        'stock_type' => 'IN',
    ]);
});

it('renders so table without foreach columns', function () {
    $r = $this->get('/wms/so/table');
    $r->assertStatus(200);
    $html = $r->getContent();
    file_put_contents(base_path('tests/dump_so_table.html'), $html);

    expect($html)->toContain('Grand Total');
    expect($html)->toContain('PPN');
    expect($html)->toContain('PPH');
});

it('renders so create form with tax inputs', function () {
    $r = $this->get('/wms/so/create');
    $r->assertStatus(200);
    $html = $r->getContent();
    file_put_contents(base_path('tests/dump_so_form.html'), $html);

    expect($html)->toContain('name="so_ppn"');
    expect($html)->toContain('name="so_ppn_rate"');
    expect($html)->toContain('name="so_pph"');
    expect($html)->toContain('name="so_pph_rate"');
    expect($html)->toContain('name="so_discount"');
    expect($html)->toContain('name="so_discount_note"');
});

it('creates so with tax fields and computes totals', function () {
    $payload = [
        'so_tanggal' => '2026-08-01',
        'so_id_customer' => $this->customer->customer_id,
        'so_status' => 'Pending',
        'so_keterangan' => 'Test',
        'so_pph' => 'exclude',
        'so_pph_rate' => 2,
        'so_ppn' => 'exclude',
        'so_ppn_rate' => 11,
        'so_discount' => 100000,
        'so_discount_note' => 'discount 20% pembelian 10 item',
        'details' => [
            [
                'so_detail_id' => null,
                'so_detail_id_product' => $this->product->product_id,
                'so_detail_qty' => 10,
            ],
        ],
    ];

    $r = $this->post('/wms/so/create', $payload);
    $r->assertStatus(302);

    $so = So::where('so_code', 'like', 'SO-%')->first();
    expect($so)->not->toBeNull();

    $so->load('details');

    expect($so->so_pph)->toBe('exclude');
    expect($so->so_pph_rate)->toBe(2);
    expect($so->so_ppn)->toBe('exclude');
    expect($so->so_ppn_rate)->toBe(11);
    expect((string) $so->so_discount)->toBe('100000');
    expect($so->so_discount_note)->toBe('discount 20% pembelian 10 item');

    // subtotal = 10 x 135000 = 1.350.000; dpp = 1.250.000
    expect($so->so_subtotal)->toBe(1350000.0);
    expect($so->so_dpp)->toBe(1250000.0);
    // ppn exclude 11% of 1.250.000
    expect(round($so->so_ppn_amount, 2))->toBe(137500.0);
    // pph exclude 2% of 1.250.000
    expect(round($so->so_pph_amount, 2))->toBe(25000.0);
    // grand = 1.250.000 + 137.500 + 25.000
    expect(round($so->so_grand_total, 2))->toBe(1412500.0);

    $r2 = $this->get('/wms/so/update/'.$so->so_id);
    $r2->assertStatus(200);
});

it('edits so tax fields', function () {
    $so = So::create([
        'so_tanggal' => '2026-08-01',
        'so_code' => 'SO-TEST-EDIT',
        'so_id_customer' => $this->customer->customer_id,
        'so_status' => 'Pending',
        'so_pph' => 'no',
        'so_pph_rate' => 2,
        'so_ppn' => 'none',
        'so_ppn_rate' => 11,
        'so_discount' => 0,
        'so_discount_note' => null,
    ]);

    $payload = [
        'so_tanggal' => '2026-08-01',
        'so_id_customer' => $this->customer->customer_id,
        'so_status' => 'Confirmed',
        'so_pph' => 'include',
        'so_pph_rate' => 2,
        'so_ppn' => 'include',
        'so_ppn_rate' => 11,
        'so_discount' => 500000,
        'so_discount_note' => 'promo',
        'details' => [
            [
                'so_detail_id' => null,
                'so_detail_id_product' => $this->product->product_id,
                'so_detail_qty' => 5,
            ],
        ],
    ];

    $r = $this->post('/wms/so/update/'.$so->so_id, $payload);
    $r->assertStatus(302);

    $so->refresh();
    expect($so->so_pph)->toBe('include');
    expect($so->so_ppn)->toBe('include');
    expect((string) $so->so_discount)->toBe('500000');
    expect($so->so_discount_note)->toBe('promo');
});
