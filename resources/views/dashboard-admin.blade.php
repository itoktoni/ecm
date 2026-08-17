@php
    $labels = [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'processing' => 'Diproses',
        'shipping' => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
    $colors = [
        'draft' => 'bg-surface-variant',
        'pending' => 'bg-amber-500',
        'processing' => 'bg-blue-500',
        'shipping' => 'bg-indigo-500',
        'completed' => 'bg-green-500',
        'cancelled' => 'bg-red-400',
    ];
    $max = max(1, max($statusCounts->all() ?: [1]));
@endphp
<x-layouts::app title="Dashboard Admin">
    <div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Dashboard Admin</h1>
            <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 h-10 px-4 text-sm font-semibold rounded-lg bg-primary text-on-primary hover:opacity-90 transition">
                <span class="material-symbols-outlined text-lg">shopping_cart_checkout</span> Kelola Order Masuk
            </a>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Total Order</p>
                <p class="font-headline-xl text-headline-xl text-primary">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Menunggu</p>
                <p class="font-headline-xl text-headline-xl text-amber-600">{{ number_format($pending) }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Selesai</p>
                <p class="font-headline-xl text-headline-xl text-green-600">{{ number_format($completed) }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Total Revenue</p>
                <p class="font-headline-xl text-headline-xl text-secondary">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Chart --}}
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">bar_chart</span>
                    Order per Status
                </h3>
                <div class="space-y-3">
                    @foreach($labels as $key => $label)
                        @php $c = (int) ($statusCounts[$key] ?? 0); @endphp
                        <div class="flex items-center gap-3">
                            <span class="w-24 text-xs text-on-surface-variant shrink-0">{{ $label }}</span>
                            <div class="flex-1 h-6 bg-surface-container rounded overflow-hidden">
                                <div class="h-full {{ $colors[$key] }}" style="width: {{ round($c / $max * 100) }}%"></div>
                            </div>
                            <span class="w-8 text-right text-sm font-semibold">{{ $c }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent orders --}}
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">receipt_long</span>
                    Order Terbaru
                </h3>
                <div class="space-y-2">
                    @forelse($recentOrders as $ord)
                        <a href="{{ route('orders.show', $ord->order_id) }}" class="flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-surface-container transition">
                            <div>
                                <p class="text-sm font-semibold text-on-surface">#{{ $ord->order_no }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $ord->customer_nama ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-primary">Rp {{ number_format($ord->order_total, 0, ',', '.') }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $ord->getStatusLabel() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-on-surface/50 py-6 text-center">Belum ada order.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
