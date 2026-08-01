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

function jasaActor(): User
{
    $user = User::create([
        'name' => 'Jasa Tester',
        'email' => 'jasa-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    test()->actingAs($user);

    return $user;
}

function jasaStock(Product $product, int $qty): Stock
{
    $gudang = Gudang::create(['gudang_nama' => 'G-'.uniqid()]);
    $lokasi = Lokasi::create(['lokasi_nama' => 'L-'.uniqid(), 'lokasi_id_gudang' => $gudang->gudang_id]);

    return Stock::create([
        'stock_code' => 'STK-'.uniqid(),
        'stock_id_product' => $product->product_id,
        'stock_id_lokasi' => $lokasi->lokasi_id,
        'stock_qty' => $qty,
        'stock_type' => 'IN',
    ]);
}

it('creates the jasa table', function () {
    expect(Schema::hasTable('jasa'))->toBeTrue();
});

it('creates and lists jasa via CRUD', function () {
    jasaActor();

    $r = $this->post('/wms/jasa/create', [
        'jasa_nama' => 'Kalibrasi',
        'jasa_icon' => 'straighten',
    ]);
    $r->assertStatus(302);

    $jasa = Jasa::where('jasa_nama', 'Kalibrasi')->first();
    expect($jasa)->not->toBeNull();
    expect($jasa->jasa_icon)->toBe('straighten');

    $r2 = $this->get('/wms/jasa/table');
    $r2->assertStatus(200);
    expect($r2->getContent())->toContain('Kalibrasi');
});

it('validates unique jasa name', function () {
    jasaActor();
    Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);

    $r = $this->post('/wms/jasa/create', [
        'jasa_nama' => 'Kalibrasi',
        'jasa_icon' => 'speed',
    ]);
    $r->assertSessionHasErrors('jasa_nama');
});

it('stores product linked to jasa with nullable harga', function () {
    jasaActor();
    $jasa = Jasa::create(['jasa_nama' => 'Perbaikan', 'jasa_icon' => 'build']);

    $r = $this->post('/wms/product/create', [
        'product_nama' => 'Perbaikan ECG Monitor',
        'product_id_jasa' => $jasa->jasa_id,
        'product_harga' => null,
    ]);
    $r->assertStatus(302);

    $p = Product::where('product_nama', 'Perbaikan ECG Monitor')->first();
    expect($p)->not->toBeNull();
    expect($p->product_id_jasa)->toBe($jasa->jasa_id);
    expect($p->product_harga)->toBeNull();
    expect($p->jasa->jasa_nama)->toBe('Perbaikan');
});

it('so create form renders jasa select and jasa options', function () {
    jasaActor();
    $jasa = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
    $customer = Customer::create(['customer_nama' => 'Cust Jasa']);

    $r = $this->get('/wms/so/create');
    $r->assertStatus(200);
    $html = $r->getContent();

    expect($html)->toContain('Kalibrasi');
    expect($html)->toContain('name="details[0][so_detail_id_jasa]"');
    expect($html)->toContain('name="details[0][so_detail_harga]"');
});

it('renders jasa and product pages', function () {
    jasaActor();
    $jasa = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
    Product::create(['product_nama' => 'Kalibrasi ECG Monitor', 'product_id_jasa' => $jasa->jasa_id, 'product_harga' => 1000000]);

    expect($this->get('/wms/jasa/table')->status())->toBe(200);
    expect($this->get('/wms/jasa/create')->status())->toBe(200);
    expect($this->get('/wms/product/create')->getContent())->toContain('Kalibrasi');
    expect($this->get('/wms/product/table')->status())->toBe(200);
});

it('filters product dropdown by jasa', function () {
    $kal = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
    $prb = Jasa::create(['jasa_nama' => 'Perbaikan', 'jasa_icon' => 'build']);

    $c = Livewire\Livewire::test('so-details', [
        'rows' => [],
        'options' => [1 => 'Kal ECG', 2 => 'Prb ECG'],
        'prices' => [1 => 1000000, 2 => null],
        'jasaOptions' => [$kal->jasa_id => 'Kalibrasi', $prb->jasa_id => 'Perbaikan'],
        'byJasa' => [
            (string) $kal->jasa_id => [1 => 'Kal ECG'],
            (string) $prb->jasa_id => [2 => 'Prb ECG'],
        ],
    ]);

    expect($c->instance()->optionsFor(0))->toBe([]);
    $c->set('rows.0.so_detail_id_jasa', (string) $kal->jasa_id);
    expect($c->instance()->optionsFor(0))->toBe([1 => 'Kal ECG']);
});

it('clears product when jasa changes', function () {
    $kal = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
    $prb = Jasa::create(['jasa_nama' => 'Perbaikan', 'jasa_icon' => 'build']);

    $c = Livewire\Livewire::test('so-details', [
        'rows' => [],
        'options' => [1 => 'Kal ECG', 2 => 'Prb ECG'],
        'prices' => [1 => 1000000, 2 => null],
        'jasaOptions' => [$kal->jasa_id => 'Kalibrasi', $prb->jasa_id => 'Perbaikan'],
        'byJasa' => [
            (string) $kal->jasa_id => [1 => 'Kal ECG'],
            (string) $prb->jasa_id => [2 => 'Prb ECG'],
        ],
    ]);

    $c->set('rows.0.so_detail_id_jasa', (string) $kal->jasa_id);
    $c->set('rows.0.so_detail_id_product', 1);
    expect($c->get('rows.0.so_detail_id_product'))->toBe(1);

    $c->set('rows.0.so_detail_id_jasa', (string) $prb->jasa_id);
    expect($c->get('rows.0.so_detail_id_product'))->toBe('');
    expect($c->get('rows.0.so_detail_harga'))->toBe('');
});

it('auto-fills harga from master and keeps it editable', function () {
    $kal = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
    $prb = Jasa::create(['jasa_nama' => 'Perbaikan', 'jasa_icon' => 'build']);

    $c = Livewire\Livewire::test('so-details', [
        'rows' => [],
        'options' => [1 => 'Kal ECG', 2 => 'Prb ECG'],
        'prices' => [1 => 1000000, 2 => null],
        'jasaOptions' => [$kal->jasa_id => 'Kalibrasi', $prb->jasa_id => 'Perbaikan'],
        'byJasa' => [
            (string) $kal->jasa_id => [1 => 'Kal ECG'],
            (string) $prb->jasa_id => [2 => 'Prb ECG'],
        ],
    ]);

    $c->set('rows.0.so_detail_id_product', 1);
    expect($c->get('rows.0.so_detail_harga'))->toBe('1000000');

    $c->set('rows.0.so_detail_harga', '950000');
    expect($c->instance()->priceOf(0))->toBe(950000.0);
});

it('creates so with manual harga for perbaikan line', function () {
    jasaActor();

    $prb = Jasa::create(['jasa_nama' => 'Perbaikan', 'jasa_icon' => 'build']);
    $customer = Customer::create(['customer_nama' => 'Cust Perbaikan']);
    $p = Product::create(['product_nama' => 'Perbaikan ECG', 'product_id_jasa' => $prb->jasa_id, 'product_harga' => null]);
    jasaStock($p, 10);

    $r = $this->post('/wms/so/create', [
        'so_tanggal' => '2026-08-01',
        'so_id_customer' => $customer->customer_id,
        'so_status' => 'Pending',
        'so_pph' => 'no',
        'so_pph_rate' => 2,
        'so_ppn' => 'none',
        'so_ppn_rate' => 11,
        'so_discount' => 0,
        'so_discount_note' => null,
        'details' => [
            [
                'so_detail_id' => null,
                'so_detail_id_jasa' => $prb->jasa_id,
                'so_detail_id_product' => $p->product_id,
                'so_detail_qty' => 1,
                'so_detail_harga' => 1250000,
            ],
        ],
    ]);
    $r->assertStatus(302);

    $so = So::first();
    $detail = $so->details->first();
    expect((string) $detail->so_detail_harga)->toBe('1250000');
    expect($so->so_subtotal)->toBe(1250000.0);
});

it('stores so detail keterangan', function () {
    jasaActor();

    $kal = Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
    $customer = Customer::create(['customer_nama' => 'Cust Ket']);
    $p = Product::create(['product_nama' => 'Kal ECG', 'product_id_jasa' => $kal->jasa_id, 'product_harga' => 1000000]);
    jasaStock($p, 10);

    $r = $this->post('/wms/so/create', [
        'so_tanggal' => '2026-08-01',
        'so_id_customer' => $customer->customer_id,
        'so_status' => 'Pending',
        'so_pph' => 'no',
        'so_pph_rate' => 2,
        'so_ppn' => 'none',
        'so_ppn_rate' => 11,
        'so_discount' => 0,
        'so_discount_note' => null,
        'details' => [
            [
                'so_detail_id' => null,
                'so_detail_id_jasa' => $kal->jasa_id,
                'so_detail_id_product' => $p->product_id,
                'so_detail_qty' => 2,
                'so_detail_harga' => 1000000,
                'so_detail_keterangan' => 'termasuk sertifikat',
            ],
        ],
    ]);
    $r->assertStatus(302);

    expect(SoDetail::first()->so_detail_keterangan)->toBe('termasuk sertifikat');
});

it('renders so detail keterangan input in form', function () {
    jasaActor();
    Jasa::create(['jasa_nama' => 'Kalibrasi', 'jasa_icon' => 'straighten']);
    Customer::create(['customer_nama' => 'Cust Ket Render']);

    $r = $this->get('/wms/so/create');
    $r->assertStatus(200);
    expect($r->getContent())->toContain('name="details[0][so_detail_keterangan]"');
});
