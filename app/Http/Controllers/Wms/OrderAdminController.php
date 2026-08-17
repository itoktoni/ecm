<?php

namespace App\Http\Controllers\Wms;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\So;
use App\Models\SoDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderAdminController extends Controller
{
    /**
     * Daftar semua order masuk (ecommerce frontend).
     */
    public function index(Request $request)
    {
        $perPage = max(1, $request->integer('per_page', 25));

        $query = Order::query()
            ->with('details', 'so')
            ->orderByDesc('order_no');

        if ($request->filled('_q')) {
            $q = (string) $request->input('_q');
            $field = (string) $request->input('_field', '');

            if ($field !== '') {
                $query->whereRaw('LOWER(' . $field . ') LIKE ?', ['%' . mb_strtolower($q) . '%']);
            } else {
                $columns = ['order_no', 'customer_nama', 'customer_email', 'customer_telepon'];
                $query->where(function ($sub) use ($q, $columns) {
                    foreach ($columns as $column) {
                        $sub->orWhereRaw('LOWER(' . $column . ') LIKE ?', ['%' . mb_strtolower($q) . '%']);
                    }
                });
            }
        }

        $orders = $query->paginate($perPage);

        return view('pages.wms.order.index', [
            'data' => $orders,
            'model' => new Order(),
            'fields' => [
                'order_no' => 'No Order',
                'customer_nama' => 'Pemesan',
                'customer_email' => 'Email',
                'order_status' => 'Status',
            ],
        ]);
    }

    /**
     * Detail satu order masuk (dapat diedit seperti sales order).
     */
    public function show(Request $request, Order $order)
    {
        $order->load('details.product', 'so', 'user');

        return view('pages.wms.order.show', [
            'model' => $order,
            'products' => Product::whereNotNull('product_id_jasa')
                ->orderBy('product_nama')
                ->get(),
            'statusOptions' => self::statusOptions(),
        ]);
    }

    /**
     * Perbarui data order & item (mirip update sales order).
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_nama' => ['required', 'string', 'max:150'],
            'customer_email' => ['nullable', 'email', 'max:150'],
            'customer_telepon' => ['nullable', 'string', 'max:50'],
            'customer_alamat' => ['nullable', 'string', 'max:250'],
            'order_tanggal' => ['nullable', 'date'],
            'order_status' => ['nullable', 'string', 'max:20'],
            'order_catatan' => ['nullable', 'string', 'max:500'],
            'order_ppn' => ['nullable', 'string', 'in:include,exclude,none'],
            'order_ppn_rate' => ['nullable', 'integer', 'min:0'],
            'order_pph' => ['nullable', 'string', 'in:include,exclude,no'],
            'order_pph_rate' => ['nullable', 'integer', 'min:0'],
            'order_discount' => ['nullable', 'numeric', 'min:0'],
            'order_discount_note' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:product,product_id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.harga' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            $order->customer_nama = $data['customer_nama'];
            $order->customer_email = $data['customer_email'] ?? null;
            $order->customer_telepon = $data['customer_telepon'] ?? null;
            $order->customer_alamat = $data['customer_alamat'] ?? null;
            $order->order_tanggal = $data['order_tanggal'] ?? now()->toDateString();
            $order->order_status = $data['order_status'] ?? $order->order_status;
            $order->order_catatan = $data['order_catatan'] ?? null;
            $order->save();

            // Ganti seluruh item order dengan item dari form.
            $order->details()->delete();
            $subtotal = 0;
            foreach ($data['items'] as $it) {
                $p = Product::findOrFail($it['product_id']);
                $harga = ($it['harga'] !== null && $it['harga'] !== '')
                    ? (float) $it['harga']
                    : (float) $p->product_harga;
                $subtotal += $harga * $it['quantity'];

                $order->details()->create([
                    'product_id' => $p->product_id,
                    'product_nama' => $p->product_nama,
                    'product_harga' => $harga,
                    'quantity' => $it['quantity'],
                    'subtotal' => $harga * $it['quantity'],
                ]);
            }

            // Hitung pajak (PPN/PPH) & diskon menggunakan rumus SO.
            $discount = max(0, (float) ($data['order_discount'] ?? 0));
            $ppnMode = $data['order_ppn'] ?? 'none';
            $ppnRate = max(0, (int) ($data['order_ppn_rate'] ?? 11));
            $pphMode = $data['order_pph'] ?? 'no';
            $pphRate = max(0, (int) ($data['order_pph_rate'] ?? 2));

            $t = So::calculateTotals($subtotal, $discount, $ppnMode, $ppnRate, $pphMode, $pphRate);

            $order->order_subtotal = $subtotal;
            $order->order_discount = $discount;
            $order->order_discount_note = $data['order_discount_note'] ?? null;
            $order->order_ppn = $ppnMode;
            $order->order_ppn_rate = $ppnRate;
            $order->order_ppn_amount = $t['ppn'];
            $order->order_pph = $pphMode;
            $order->order_pph_rate = $pphRate;
            $order->order_pph_amount = $t['pph'];
            $order->order_tax = round($t['ppn'] + $t['pph'], 2);
            $order->order_total = $t['grand_total'];
            $order->save();

            DB::commit();

            return redirect()->route('orders.show', $order->order_id)->with('flasher', [
                'success' => 'Order #' . $order->order_no . ' berhasil diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('flasher', [
                'error' => 'Gagal memperbarui order: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Opsi status order untuk form.
     */
    public static function statusOptions(): array
    {
        return [
            'draft' => 'Draft',
            'pending' => 'Pending (Menunggu Konfirmasi)',
            'processing' => 'Diproses',
            'shipping' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }

    /**
     * Konversi order menjadi Sales Order (SO) WMS.
     */
    public function toSo(Request $request, Order $order)
    {
        $order->load('details');

        if ($order->order_so_id) {
            return back()->with('flasher', [
                'error' => 'Order #' . $order->order_no . ' sudah dijadikan SO.',
            ]);
        }

        DB::beginTransaction();
        try {
            // Cari customer berdasarkan nama, buat baru bila belum ada.
            $customer = Customer::where('customer_nama', $order->customer_nama)->first();

            if (! $customer) {
                $customer = Customer::create([
                    'customer_nama' => $order->customer_nama,
                    'customer_telepon' => $order->customer_telepon,
                    'customer_alamat' => $order->customer_alamat,
                ]);
            }

            // Buat SO header (so_code di-generate otomatis di model).
            $so = new So();
            $so->so_tanggal = now()->toDateString();
            $so->so_id_customer = $customer->customer_id;
            $so->so_reference = (string) $order->order_no;
            $so->so_keterangan = 'Dibuat dari Order #' . $order->order_no . ' oleh ' . ($order->customer_nama ?: '-');
            $so->save();

            // Salin item order ke detail SO.
            $line = 0;
            foreach ($order->details as $d) {
                $line++;
                $detail = new SoDetail();
                $detail->so_detail_id_product = $d->product_id;
                $detail->so_detail_qty = $d->quantity;
                $detail->so_detail_harga = $d->product_harga;
                $detail->so_detail_keterangan = $d->product_nama;
                $detail->so_detail_code = $so->so_code . '-' . str_pad((string) $line, 3, '0', STR_PAD_LEFT);
                $so->details()->save($detail);
            }

            // Tandai order sudah dikonversi.
            $order->order_so_id = $so->so_id;
            $order->save();

            DB::commit();

            return redirect()->route('orders.show', $order->order_id)->with('flasher', [
                'success' => 'Order #' . $order->order_no . ' berhasil dijadikan SO ' . $so->so_code . '.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('flasher', [
                'error' => 'Gagal menjadikan SO: ' . $e->getMessage(),
            ]);
        }
    }
}
