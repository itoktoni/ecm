@php
    $pekerjaan = $pekerjaan ?? collect();
@endphp
<x-layouts::app title="Dashboard Teknisi">
    <div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Dashboard Teknisi</h1>
            <a href="{{ route('wms-pekerjaan.getTable') }}" class="inline-flex items-center gap-2 h-10 px-4 text-sm font-semibold rounded-lg bg-primary text-on-primary hover:opacity-90 transition">
                <span class="material-symbols-outlined text-lg">engineering</span> Pekerjaan Saya
            </a>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Total Diambil</p>
                <p class="font-headline-xl text-headline-xl text-primary">{{ number_format($totalTaken) }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Sedang Dikerjakan</p>
                <p class="font-headline-xl text-headline-xl text-blue-600">{{ number_format($diambil) }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Alat Selesai</p>
                <p class="font-headline-xl text-headline-xl text-green-600">{{ number_format($selesai) }}</p>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4">
                <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Alat Tersedia</p>
                <p class="font-headline-xl text-headline-xl text-amber-600">{{ number_format($tersedia) }}</p>
            </div>
        </div>

        {{-- Alat dikerjakan (bar) --}}
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 mb-6">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">handyman</span>
                Banyak Alat yang Dikerjakan
            </h3>
            <div class="flex items-end gap-6">
                <div class="flex-1 text-center">
                    <p class="font-headline-xl text-headline-xl text-blue-600">{{ number_format($diambil) }}</p>
                    <p class="text-xs text-on-surface-variant">Dalam Pengerjaan</p>
                </div>
                <div class="flex-1 text-center">
                    <p class="font-headline-xl text-headline-xl text-green-600">{{ number_format($selesai) }}</p>
                    <p class="text-xs text-on-surface-variant">Selesai</p>
                </div>
                <div class="flex-1 text-center">
                    <p class="font-headline-xl text-headline-xl text-primary">{{ number_format($totalTaken) }}</p>
                    <p class="text-xs text-on-surface-variant">Total</p>
                </div>
            </div>
        </div>

        {{-- Daftar pekerjaan --}}
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">assignment</span>
                Pekerjaan Terakhir
            </h3>
            <div class="space-y-2">
                @forelse($pekerjaan as $p)
                    <div class="flex items-center justify-between gap-2 p-2 rounded-lg border border-outline-variant/50">
                        <div>
                            <p class="text-sm font-semibold text-on-surface">{{ $p->product?->product_nama ?? '-' }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $p->so?->so_code ?? '-' }} · {{ $p->so_detail_qty }} pcs</p>
                        </div>
                        <span class="px-2.5 py-0.5 text-xs font-medium rounded-full border {{ $p->so_detail_kerja_status==='Selesai' ? 'border-green-200 bg-green-50 text-green-700' : ($p->so_detail_kerja_status==='Diambil' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-amber-200 bg-amber-50 text-amber-700') }}">
                            {{ $p->so_detail_kerja_status ?? 'Tersedia' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-on-surface/50 py-6 text-center">Belum ada pekerjaan diambil.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>
