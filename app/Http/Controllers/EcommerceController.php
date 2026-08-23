<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EcommerceController extends Controller
{
    /**
     * Daftar order customer yang sedang login.
     * Route: /order  (GET)
     */
    public function index(Request $request)
    {
        $orders = collect();

        if (Auth::guard('web')->check()) {
            $orders = Auth::user()
                ->orders()
                ->with('details')
                ->latest('order_id')
                ->get();
        }

        return view('frontend.pages.order.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Form checkout — produk dipilih dikirim via query ?product_id=.
     * Route: /order/create  (GET)
     */
    public function create(Request $request)
    {
        if (! Auth::guard('web')->check()) {
            return redirect()->route('login')->with('flasher', [
                'error' => 'Silakan login terlebih dahulu untuk mengorder.',
            ]);
        }

        $product = null;
        if ($request->filled('product_id')) {
            $product = Product::where('product_id', $request->product_id)->firstOrFail();
        }

        // Produk yang bisa dipesan di frontend (hanya yang termasuk jasa ecommerce)
        $products = Product::whereNotNull('product_id_jasa')
            ->with('jasa')
            ->orderBy('product_nama')
            ->get();

        return view('frontend.pages.order.checkout', [
            'product' => $product,
            'products' => $products,
        ]);
    }

    /**
     * Simpan order (store) — semua logika penghitungan & transaksi di sini.
     * Route: /order  (POST)
     */
    public function store(Request $request)
    {
        if (! Auth::guard('web')->check()) {
            return redirect()->route('login')->with('flasher', [
                'error' => 'Silakan login terlebih dahulu untuk mengorder.',
            ]);
        }

        $user = Auth::user();

        $data = $request->validate([
            'customer_nama' => 'required|string|max:150',
            'customer_email' => 'required|email|max:150',
            'customer_telepon' => 'required|string|max:50',
            'customer_alamat' => 'nullable|string',
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => 'required|exists:product,product_id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->order_no = Order::generateNo();
            $order->user_id = $user->id;
            $order->customer_nama = $data['customer_nama'];
            $order->customer_email = $data['customer_email'];
            $order->customer_telepon = $data['customer_telepon'];
            $order->customer_alamat = $data['customer_alamat'];
            $order->order_tanggal = now()->toDateString();
            $order->order_catatan = $request->string('order_catatan');
            $order->order_status = 'pending';
            // Simpan dulu agar order_id (auto-increment) tersedia
            $order->save();

            $subtotal = 0;
            foreach ($data['cart'] as $item) {
                $product = Product::where('product_id', $item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();
                $line = $product->product_harga * $item['quantity'];
                $subtotal += $line;

                $detail = new OrderDetail();
                $detail->product_id = $product->product_id;
                $detail->product_nama = $product->product_nama;
                $detail->product_harga = $product->product_harga;
                $detail->quantity = $item['quantity'];
                $detail->subtotal = $line;
                $order->details()->save($detail);
            }

            $tax = round($subtotal * 0.11, 2);
            $discount = 0;
            $total = round($subtotal + $tax - $discount, 2);

            $order->order_subtotal = $subtotal;
            $order->order_tax = $tax;
            $order->order_discount = $discount;
            $order->order_total = $total;
            $order->save();

            DB::commit();

            return redirect()->route('order.index')->with('flasher', [
                'success' => 'Order #' . $order->order_no . ' berhasil dikirim. Kami akan menghubungi Anda untuk konfirmasi.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('flasher', [
                'error' => 'Gagal menyimpan order: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Detail satu order customer.
     * Route: /order/{order}  (GET)
     */
    public function show(Request $request, Order $order)
    {
        if (! Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        // Pastikan order adalah milik customer yang login
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        $order->load('details.product');

        return view('frontend.pages.order.show', [
            'order' => $order,
        ]);
    }
}
