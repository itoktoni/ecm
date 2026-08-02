<?php /** @var \Illuminate\Contracts\Pagination\CursorPaginator $data */ ?>
@php $me = $userId ?? auth()->id(); @endphp

<x-layouts::app>
    <x-breadcrumb :items="[['url' => '/dashboard', 'label' => 'Home'], ['url' => '', 'label' => 'Pekerjaan Saya']]" />

    <div class="content mt-4 lg:mt-0">
        @if(session('error'))
            <div class="mb-4 flex items-center gap-2 rounded-lg border border-error bg-error/10 px-4 py-3 text-error font-body-sm">
                <span class="material-symbols-outlined">error</span>{{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-4 flex items-center gap-2 rounded-lg border border-primary bg-primary/10 px-4 py-3 text-primary font-body-sm">
                <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
            </div>
        @endif

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">engineering</span>
                Pekerjaan Tersedia &amp; Diambil
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full font-body-sm">
                    <thead>
                        <tr class="text-left border-b border-outline-variant text-on-surface-variant">
                            <th class="py-2 px-3">SO</th>
                            <th class="py-2 px-3">Customer</th>
                            <th class="py-2 px-3">Product</th>
                            <th class="py-2 px-3 text-center">Qty</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3">Teknisi</th>
                            <th class="py-2 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                            <tr class="border-b border-outline-variant/50">
                                <td class="py-2 px-3 font-medium">{{ $row->so?->so_code }}</td>
                                <td class="py-2 px-3">{{ $row->so?->customer?->customer_nama ?? '-' }}</td>
                                <td class="py-2 px-3">{{ $row->product?->product_nama ?? '-' }}</td>
                                <td class="py-2 px-3 text-center">{{ $row->so_detail_qty }}</td>
                                <td class="py-2 px-3">
                                    @if($row->so_detail_kerja_status === 'Selesai')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                    @elseif($row->so_detail_kerja_status === 'Diambil')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diambil</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Tersedia</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">{{ $row->teknisi?->name ?? '-' }}</td>
                                <td class="py-2 px-3">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($row->so_detail_kerja_status === 'Tersedia')
                                            <a href="{{ route('wms-pekerjaan.getAmbil', ['id' => $row->so_detail_id]) }}"
                                                class="inline-flex items-center gap-1.5 h-9 px-3 rounded-lg bg-primary text-on-primary text-xs font-semibold hover:opacity-90 transition-opacity">
                                                <span class="material-symbols-outlined text-base">pan_tool</span> Ambil
                                            </a>
                                        @elseif((int) $row->so_detail_id_teknisi === (int) $me)
                                            <a href="{{ route('wms-pekerjaan.getLembar', ['id' => $row->so_detail_id]) }}"
                                                class="inline-flex items-center gap-1.5 h-9 px-3 rounded-lg border border-outline-variant text-on-surface-variant text-xs font-semibold hover:bg-surface-container transition-all">
                                                <span class="material-symbols-outlined text-base">assignment</span> Lembar Kerja
                                            </a>
                                            @if($row->so_detail_kerja_status === 'Selesai')
                                                <a href="{{ route('wms-pekerjaan.getBeritaAcara', ['id' => $row->so_detail_id]) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 h-9 px-3 rounded-lg border border-outline-variant text-on-surface-variant text-xs font-semibold hover:bg-surface-container transition-all">
                                                    <span class="material-symbols-outlined text-base">description</span> Berita Acara
                                                </a>
                                                <a href="{{ route('wms-pekerjaan.getSertifikat', ['id' => $row->so_detail_id]) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 h-9 px-3 rounded-lg border border-outline-variant text-on-surface-variant text-xs font-semibold hover:bg-surface-container transition-all">
                                                    <span class="material-symbols-outlined text-base">workspace_premium</span> Sertifikat
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-xs text-on-surface-variant italic">Diambil {{ $row->teknisi?->name }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-6 text-on-surface-variant">Belum ada pekerjaan. Anda harus terdaftar sebagai petugas pada Sales Order.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <x-pagination :paginator="$data" />
            </div>
        </div>
    </div>
</x-layouts::app>
