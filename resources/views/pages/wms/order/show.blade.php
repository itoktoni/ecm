<?php /** @var \App\Models\Order $model */ ?>
@php
    $items = old('items', $model->details->map(fn ($d) => ['product_id' => $d->product_id, 'quantity' => $d->quantity, 'harga' => $d->product_harga])->values()->all());
    $priceMap = $products->mapWithKeys(fn ($p) => [(string) $p->product_id => (string) $p->product_harga]);
@endphp
<x-layouts::app>
    <x-breadcrumb :items="[['url' => '/dashboard', 'label' => 'Home'], ['url' => '/wms/orders', 'label' => 'Order Masuk'], ['url' => '', 'label' => '#'.$model->order_no]]" />
    <div class="content mt-4 lg:mt-0">
        @include('pages.wms.order._flash')

        @if($model->order_so_id)
            <div class="mb-4 px-4 py-3 rounded-lg border text-sm bg-green-50 border-green-200 text-green-800 flex items-center justify-between gap-3">
                <span class="font-medium">Order ini sudah dijadikan Sales Order.</span>
                <a href="{{ route('wms-so.getUpdate', ['id' => $model->so?->so_id ?? $model->order_so_id]) }}"
                   class="inline-flex items-center gap-1 font-semibold text-green-900 hover:underline shrink-0">
                    <span class="material-symbols-outlined text-lg">point_of_sale</span> Buka SO
                </a>
            </div>
        @endif
        <form method="POST" action="{{ route('orders.update', $model->order_id) }}" id="order-form">
            @csrf
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <h1 class="font-headline-md text-lg text-on-surface">Update Order #{{ $model->order_no }}</h1>
                <div class="flex items-center gap-2">
                    @if($model->order_so_id)
                        <a href="{{ route('wms-so.getUpdate', ['id' => $model->so?->so_id ?? $model->order_so_id]) }}"
                           class="px-3 py-2 rounded-lg bg-surface-container-high text-on-surface text-sm hover:bg-surface-container transition-colors inline-flex items-center gap-1">
                            Sudah dijadikan SO: <span class="font-semibold">#{{ $model->so?->so_code ?? $model->order_so_id }}</span>
                        </a>
                    @else
                        <form method="POST" action="{{ route('orders.to-so', $model->order_id) }}" onsubmit="return confirm('Jadikan order ini sebagai Sales Order (SO)?');">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 h-10 px-4 text-sm font-semibold rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-lg">point_of_sale</span> Jadikan SO</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-5">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h2 class="font-headline-md text-base text-on-surface mb-4">Data Order</h2>
                    <div class="space-y-4">
                        <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Tanggal Order</label><input type="date" name="order_tanggal" value="{{ old('order_tanggal', $model->order_tanggal?->format('Y-m-d')) }}" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" /></div>
                        <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Status</label>
                            <select name="order_status" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none">
                                @foreach($statusOptions as $val => $label)<option value="{{ $val }}" @selected(old('order_status', $model->order_status) === $val)>{{ $label }}</option>@endforeach
                            </select></div>
                        <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Catatan</label><textarea name="order_catatan" rows="3" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none">{{ old('order_catatan', $model->order_catatan) }}</textarea></div>
                        </div>
                        </div>
                        <div>
                            <h2 class="font-headline-md text-base text-on-surface mb-4">Pemesan</h2>
                    <div class="space-y-4">
                        <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Nama Lengkap</label><input type="text" name="customer_nama" value="{{ old('customer_nama', $model->customer_nama) }}" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" required /></div>
                        <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Email</label><input type="email" name="customer_email" value="{{ old('customer_email', $model->customer_email) }}" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" /></div>
                        <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Telepon</label><input type="text" name="customer_telepon" value="{{ old('customer_telepon', $model->customer_telepon) }}" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none" /></div>
                        <div><label class="block font-label-md text-sm text-on-surface/70 mb-1">Alamat</label><textarea name="customer_alamat" rows="2" class="w-full px-3 py-2.5 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none">{{ old('customer_alamat', $model->customer_alamat) }}</textarea></div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-outline-variant/30 p-5">
                    <div class="flex items-center justify-between mb-4"><h2 class="font-headline-md text-base text-on-surface">Item Order</h2><button type="button" id="add-item" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:underline"><span class="material-symbols-outlined text-base">add</span> Tambah Baris</button></div>
                    <div id="items-wrapper" class="space-y-3"></div>
                    <div class="mt-4 pt-3 border-t space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div><label class="block text-xs text-on-surface/60 mb-0.5">Diskon</label><input type="number" id="order_discount" name="order_discount" value="{{ old('order_discount', $model->order_discount) }}" step="any" min="0" class="ord-tax w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm" /></div>
                            <div><label class="block text-xs text-on-surface/60 mb-0.5">Diskon Note</label><input type="text" id="order_discount_note" name="order_discount_note" value="{{ old('order_discount_note', $model->order_discount_note) }}" class="w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm" /></div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div><label class="block text-xs text-on-surface/60 mb-0.5">PPN</label><select id="order_ppn" name="order_ppn" class="ord-tax w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm">
                                @foreach(['include'=>'Include','exclude'=>'Exclude','none'=>'None'] as $v=>$l)<option value="{{ $v }}" @selected(old('order_ppn', $model->order_ppn ?? 'none') === $v)>{{ $l }}</option>@endforeach
                            </select></div>
                            <div><label class="block text-xs text-on-surface/60 mb-0.5">PPN Rate %</label><input type="number" id="order_ppn_rate" name="order_ppn_rate" value="{{ old('order_ppn_rate', $model->order_ppn_rate ?? 11) }}" min="0" class="ord-tax w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm" /></div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div><label class="block text-xs text-on-surface/60 mb-0.5">PPH</label><select id="order_pph" name="order_pph" class="ord-tax w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm">
                                @foreach(['include'=>'Include','exclude'=>'Exclude','no'=>'No'] as $v=>$l)<option value="{{ $v }}" @selected(old('order_pph', $model->order_pph ?? 'no') === $v)>{{ $l }}</option>@endforeach
                            </select></div>
                            <div><label class="block text-xs text-on-surface/60 mb-0.5">PPH Rate %</label><input type="number" id="order_pph_rate" name="order_pph_rate" value="{{ old('order_pph_rate', $model->order_pph_rate ?? 2) }}" min="0" class="ord-tax w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm" /></div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t space-y-1 text-sm">
                        <div class="flex justify-between"><span class="text-on-surface/60">Subtotal</span><span id="sum2-subtotal">Rp 0</span></div>
                        <div class="flex justify-between"><span class="text-on-surface/60">Diskon</span><span id="sum2-discount">Rp 0</span></div>
                        <div class="flex justify-between"><span class="text-on-surface/60">DPP</span><span id="sum2-dpp">Rp 0</span></div>
                        <div class="flex justify-between"><span class="text-on-surface/60">PPN</span><span id="sum2-ppn">Rp 0</span></div>
                        <div class="flex justify-between"><span class="text-on-surface/60">PPH</span><span id="sum2-pph">Rp 0</span></div>
                        <div class="flex justify-between font-headline-md text-primary"><span>Grand Total</span><span id="sum2-grand">Rp 0</span></div>
                    </div>
                    <div class="flex flex-wrap gap-3 mt-5">
                        <button type="submit" class="inline-flex items-center gap-2 h-10 px-5 text-sm font-semibold rounded-lg bg-primary text-on-primary hover:bg-primary/90 transition-colors"><span class="material-symbols-outlined text-xl">save</span> Simpan Perubahan</button>
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 h-10 px-5 text-sm font-semibold rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-colors">Batal</a>
                    </div>
                </div>
            </div>
        </form>
        <a href="{{ route('orders.index') }}" class="inline-block mt-4 text-secondary hover:underline text-sm">← Kembali ke Daftar Order Masuk</a>
    </div>
    <input type="hidden" id="price-map" value="{{ json_encode($priceMap) }}" />
    <template id="item-tpl">
        <div class="item-row border border-outline-variant/40 rounded-lg p-3 space-y-2">
            <div class="flex gap-2">
                <select name="items[IDX][product_id]" class="item-product flex-1 min-w-0 px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm">
                    <option value="">Pilih produk...</option>
                    @foreach($products as $p)<option value="{{ $p->product_id }}" data-harga="{{ $p->product_harga }}">{{ $p->product_nama }} - {{ number_format($p->product_harga,0,',','.') }}</option>@endforeach
                </select>
                <button type="button" class="item-remove w-9 h-9 shrink-0 inline-flex items-center justify-center rounded-lg bg-error/10 text-error hover:bg-error/20 transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
            </div>
            <div class="flex gap-2">
                <div class="flex-1"><label class="block text-xs text-on-surface/60 mb-0.5">Qty</label><input type="number" name="items[IDX][quantity]" class="item-qty w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm" value="1" min="1" /></div>
                <div class="flex-1"><label class="block text-xs text-on-surface/60 mb-0.5">Harga</label><input type="number" name="items[IDX][harga]" class="item-harga w-full px-2 py-2 rounded-lg border border-outline-variant/50 focus:ring-2 focus:ring-primary outline-none text-sm" step="any" min="0" value="0" /></div>
                <div class="flex-1"><label class="block text-xs text-on-surface/60 mb-0.5">Subtotal</label><div class="item-subtotal px-2 py-2 text-sm text-on-surface/70 bg-surface-container-low rounded-lg">Rp 0</div></div>
            </div>
        </div>
    </template>
    <script>
    (function () {
        var prices = JSON.parse(document.getElementById('price-map').value || '{}');
        var tpl = document.getElementById('item-tpl');
        var wrap = document.getElementById('items-wrapper');
        var idx = 0;
        function fmt(n) { return 'Rp ' + Number(n||0).toLocaleString('id-ID'); }
        function reindex() {
            wrap.querySelectorAll('.item-row').forEach(function (row, i) {
                row.querySelectorAll('[name*="[IDX]"]').forEach(function (el) {
                    el.name = el.name.replace('[IDX]', '[' + i + ']');
                });
            });
        }
        function recompute() {
            var subtotal = 0;
            wrap.querySelectorAll('.item-row').forEach(function (row) {
                var qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                var harga = parseFloat(row.querySelector('.item-harga').value) || 0;
                var sub = qty * harga;
                subtotal += sub;
                row.querySelector('.item-subtotal').textContent = fmt(sub);
            });
            var discount = parseFloat(document.getElementById('order_discount').value) || 0;
            var ppnMode = document.getElementById('order_ppn').value;
            var ppnRate = parseFloat(document.getElementById('order_ppn_rate').value) || 0;
            var pphMode = document.getElementById('order_pph').value;
            var pphRate = parseFloat(document.getElementById('order_pph_rate').value) || 0;
            var dpp = Math.max(0, subtotal - discount);
            var ppn = ppnMode === 'exclude' ? dpp * ppnRate / 100 : (ppnMode === 'include' ? dpp * ppnRate / (100 + ppnRate) : 0);
            var pph = pphMode === 'exclude' ? dpp * pphRate / 100 : (pphMode === 'include' ? dpp * pphRate / (100 + pphRate) : 0);
            var tax = ppn + pph;
            var grand = dpp + (ppnMode === 'exclude' ? ppn : 0) + (pphMode === 'exclude' ? pph : 0);
            document.getElementById('sum-subtotal').textContent = fmt(subtotal);
            document.getElementById('sum-tax').textContent = fmt(tax);
            document.getElementById('sum-total').textContent = fmt(grand);
            document.getElementById('sum2-subtotal').textContent = fmt(subtotal);
            document.getElementById('sum2-discount').textContent = fmt(discount);
            document.getElementById('sum2-dpp').textContent = fmt(dpp);
            document.getElementById('sum2-ppn').textContent = fmt(ppn);
            document.getElementById('sum2-pph').textContent = fmt(pph);
            document.getElementById('sum2-grand').textContent = fmt(grand);
        }
        function addRow(data) {
            var node = tpl.content.cloneNode(true);
            node.querySelectorAll('[name*="[IDX]"]').forEach(function (el) {
                el.name = el.name.replace('[IDX]', '[' + idx + ']');
            });
            var row = node.querySelector('.item-row');
            var sel = row.querySelector('.item-product');
            if (data) {
                sel.value = String(data.product_id);
                row.querySelector('.item-qty').value = data.quantity;
                row.querySelector('.item-harga').value = data.harga;
            }
            sel.addEventListener('change', function () {
                var opt = sel.options[sel.selectedIndex];
                var hp = opt ? opt.dataset.harga : 0;
                if (hp !== undefined && hp !== '') row.querySelector('.item-harga').value = hp;
                recompute();
            });
            row.querySelector('.item-remove').addEventListener('click', function () {
                row.remove(); reindex(); recompute();
            });
            row.querySelectorAll('.item-qty,.item-harga').forEach(function (el) { el.addEventListener('input', recompute); });
            wrap.appendChild(node);
            idx++;
        }
        document.getElementById('add-item').addEventListener('click', function () { addRow({ product_id: '', quantity: 1, harga: 0 }); try { recompute(); } catch (e) {} });
        ['order_discount','order_discount_note','order_ppn','order_ppn_rate','order_pph','order_pph_rate'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('change', recompute);
        });
        var dd = document.getElementById('order_discount');
        if (dd) dd.addEventListener('input', recompute);
        var initial = {!! json_encode($items) !!};
        if (initial && initial.length) {
            initial.forEach(function (it) { addRow(it); });
        } else {
            addRow({ product_id: '', quantity: 1, harga: 0 });
        }
        try { recompute(); } catch (e) {}
    })();
    </script>
</x-layouts::app>
