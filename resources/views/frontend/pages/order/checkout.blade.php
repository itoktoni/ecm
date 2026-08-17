@extends('frontend.layouts.public')
@section('title', 'Checkout Order')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-16 min-h-screen">
<script src="/vendor/flasher/flasher.min.js"></script>
<link href="/vendor/flasher/flasher.min.css" rel="stylesheet" />
@include('layouts.alert')
@if(session('flasher'))
    @php $fm = \Illuminate\Support\Arr::first(session('flasher')); $ft = session('flasher.success') ? 'success' : 'error'; @endphp
    <input type="hidden" id="flash-msg" value="{{ json_encode(['t' => $ft, 'm' => $fm]) }}" />
@endif
<h1 class="text-3xl font-headline-lg text-primary mb-8">Checkout Order</h1>
<form id="order-form" method="POST" action="{{ route('order.store') }}">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">
        <div class="lg:col-span-2">
            <div class="collapsible bg-white rounded-xl shadow-sm border border-outline-variant/30 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-headline-md text-lg text-primary">Data Customer</h2>
                    <button type="button" class="collapse-toggle flex items-center justify-center w-7 h-7 rounded-lg text-on-surface-variant hover:bg-surface-container-low" onclick="toggleCard(this)" aria-label="Collapse Data Customer">
                        <span class="material-symbols-outlined collapse-icon text-lg">expand_less</span>
                    </button>
                </div>
                <div class="space-y-4 collapsible-body">
                    <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Nama Lengkap</label>
                        <input type="text" name="customer_nama" value="{{ auth()->user()->name ?? '' }}" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" required /></div>
                    <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Email</label>
                        <input type="email" name="customer_email" value="{{ auth()->user()->email ?? '' }}" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" required /></div>
                    <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Telepon</label>
                        <input type="text" name="customer_telepon" value="{{ auth()->user()->phone ?? '' }}" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" required /></div>
                    <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Alamat Lengkap</label>
                        <textarea name="customer_alamat" rows="3" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" required></textarea></div>
                    <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Catatan (opsional)</label>
                        <textarea name="order_catatan" rows="2" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none"></textarea></div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5">
            <div class="collapsible bg-white rounded-xl shadow-sm border border-outline-variant/30 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-headline-md text-lg text-primary">Pilih Produk</h2>
                    <button type="button" class="collapse-toggle flex items-center justify-center w-7 h-7 rounded-lg text-on-surface-variant hover:bg-surface-container-low" onclick="toggleCard(this)" aria-label="Collapse Pilih Produk">
                        <span class="material-symbols-outlined collapse-icon text-lg">expand_less</span>
                    </button>
                </div>
                <div class="collapsible-body">
                <p class="text-xs text-on-surface/60 mb-4">Klik produk untuk menambahkannya ke keranjang. Klik berulang kali untuk menambah jumlah.</p>
                <div class="mb-4">
                    <input type="text" id="search-product" placeholder="Cari produk..." autocomplete="off"
                           class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 pt-4 gap-3 max-h-96 overflow-y-auto overflow-x-hidden pr-1">
                    @foreach($products as $p)
                        <button type="button" class="product-card relative block w-full min-w-0 text-left border border-outline-variant/40 rounded-lg p-3 cursor-pointer hover:border-primary transition group" data-id="{{ $p->product_id }}" data-nama="{{ $p->product_nama }}" data-jasa="{{ $p->jasa_nama }}" data-harga="{{ (float)$p->product_harga }}" onclick="addToCart(this)">
                            <span class="flex justify-between gap-2">
                                <span class="font-label-md break-words">{{ $p->product_nama }}</span>
                                <span class="font-label-md text-secondary shrink-0">Rp {{ number_format($p->product_harga, 0, ',', '.') }}</span>
                            </span>
                            @if($p->jasa_nama !== '-')
                                <span class="text-xs text-on-surface/60">Jasa: {{ $p->jasa_nama }}</span>
                            @endif
                            <span class="qty-badge absolute -top-2 -right-2 bg-primary text-on-primary text-xs rounded-full px-2 py-0.5 hidden">0</span>
                        </button>
                    @endforeach
                </div>
                </div>
            </div>
            <div class="collapsible bg-white rounded-xl shadow-sm border border-outline-variant/30 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-headline-md text-lg text-primary">Keranjang</h2>
                    <button type="button" class="collapse-toggle flex items-center justify-center w-7 h-7 rounded-lg text-on-surface-variant hover:bg-surface-container-low" onclick="toggleCard(this)" aria-label="Collapse Keranjang">
                        <span class="material-symbols-outlined collapse-icon text-lg">expand_less</span>
                    </button>
                </div>
                <div class="collapsible-body">
                <div id="cart-area">
                    <table class="w-full text-sm">
                        <thead><tr class="text-left text-on-surface/60"><th class="py-1">Produk</th><th class="py-1 text-right">Qty</th><th class="py-1 text-right">Subtotal</th></tr></thead>
                        <tbody id="cart-body"></tbody>
                        <tfoot><tr class="border-t"><td class="pt-2 text-right font-label-md" colspan="2">Total</td><td class="pt-2 text-right font-headline-md text-primary" id="cart-total">Rp 0</td></tr></tfoot>
                    </table>
                </div>
                <p class="text-xs text-on-surface/50 mt-2">Klik <b>&minus;</b> bila jumlah <b>1</b> untuk menghapus produk dari keranjang.</p>
                </div>
            </div>
            <button type="submit" id="submit-btn" class="w-full bg-primary text-on-primary py-3 rounded-lg font-label-md hover:opacity-90 transition" disabled>Kirimkan Order</button>
            <a href="{{ route('order.index') }}" class="block text-center text-sm text-on-surface/60 hover:text-primary mt-3">← Kembali ke Order Saya</a>
        </div>
    </div>
</form>
@php $preset = isset($product) && $product ? ['id' => $product->product_id, 'nama' => $product->product_nama, 'harga' => (float)$product->product_harga] : null; @endphp
<input type="hidden" id="preset-product" value="{{ $preset ? base64_encode(json_encode($preset)) : '' }}" />
<script>
var cart = [];
const fmt = n => 'Rp ' + Number(n).toLocaleString('id-ID');
function addToCart(el) {
    var id = parseInt(el.dataset.id);
    var nama = el.dataset.nama;
    var harga = parseFloat(el.dataset.harga);
    var idx = cart.findIndex(x => x.id === id);
    if (idx >= 0) { cart[idx].qty++; } else { cart.push({id:id, nama:nama, harga:harga, qty:1}); }
    renderCart();
}
function renderCart() {
    var body = document.getElementById('cart-body');
    var totalEl = document.getElementById('cart-total');
    var btn = document.getElementById('submit-btn');
    var html = '';
    var total = 0;
    cart.forEach((it, i) => {
        total += it.harga * it.qty;
        html += '<tr class="border-b"><td class="py-2"><span>'+it.nama+'</span></td>';
        html += '<input type="hidden" name="cart['+i+'][product_id]" value="'+it.id+'" />';
        html += '<input type="hidden" name="cart['+i+'][quantity]" value="'+it.qty+'" />';
        html += '<td class="py-2 text-right"><button type="button" onclick="dec('+i+')" class="text-xs text-red-500 mr-1">−</button><span class="text-xs">'+it.qty+'</span><button type="button" onclick="inc('+i+')" class="text-xs text-green-600 ml-1">+</button></td>';
        html += '<td class="py-2 text-right">'+fmt(it.harga*it.qty)+'</td></tr>';
    });
    body.innerHTML = html;
    totalEl.textContent = fmt(total);
    btn.disabled = cart.length === 0;
    updateCardUI();
}
function inc(i) { cart[i].qty++; renderCart(); }
function dec(i) { cart[i].qty--; if (cart[i].qty < 1) cart.splice(i, 1); renderCart(); }
function updateCardUI() {
    var cards = document.querySelectorAll('.product-card');
    cards.forEach(card => {
        var id = parseInt(card.dataset.id);
        var idx = cart.findIndex(x => x.id === id);
        var badge = card.querySelector('.qty-badge');
        if (idx >= 0 && cart[idx].qty > 0) {
            card.classList.add('border-primary', 'bg-surface-container-low/40');
            badge.classList.remove('hidden');
            badge.textContent = cart[idx].qty;
        } else {
            card.classList.remove('border-primary', 'bg-surface-container-low/40');
            badge.classList.add('hidden');
        }
    });
}
// collapse / expand card
function toggleCard(btn) {
    var card = btn.closest('.collapsible');
    if (!card) return;
    var body = card.querySelector('.collapsible-body');
    var icon = btn.querySelector('.collapse-icon');
    body.classList.toggle('hidden');
    icon.textContent = body.classList.contains('hidden') ? 'expand_more' : 'expand_less';
}
// flash notice
(function () {
    var f = document.getElementById('flash-msg');
    if (!f || !f.value) return;
    var o = JSON.parse(atob(f.value));
    var show = true;
    document.addEventListener('DOMContentLoaded', function () { if (window.flasher && o.m) (o.t === 'success' ? flasher.success : flasher.error)(o.m); });
})();
// preset
var presetRaw = document.getElementById('preset-product').value;
if (presetRaw) {
    try {
        var preset = JSON.parse(atob(presetRaw));
        if (preset) addToCart({ dataset: { id: preset.id, nama: preset.nama, harga: preset.harga } });
    } catch (e) { /* abaikan preset rusak */ }
}
// search / filter produk
(function () {
    var input = document.getElementById('search-product');
    if (!input) return;
    input.addEventListener('input', function () {
        var q = input.value.trim().toLowerCase();
        document.querySelectorAll('.product-card').forEach(function (card) {
            var nama = (card.dataset.nama || '').toLowerCase();
            var jasa = card.getAttribute('data-jasa') ? card.getAttribute('data-jasa').toLowerCase() : '';
            card.style.display = (!q || nama.indexOf(q) !== -1 || jasa.indexOf(q) !== -1) ? '' : 'none';
        });
    });
})();
</script>
</div>
@endsection
