<?php /** @var App\Models\SoDetail $model */ ?>

<x-layouts::app>
    <x-breadcrumb :items="[['url' => route('wms-pekerjaan.getTable'), 'label' => 'Pekerjaan'], ['url' => '', 'label' => 'Lembar Kerja']]" />

    @if(session('success'))
        <div class="mt-4 flex items-center gap-2 rounded-lg border border-primary bg-primary/10 px-4 py-3 text-primary font-body-sm">
            <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('wms-pekerjaan.postLembar', ['id' => $model->so_detail_id]) }}" class="mt-4 lg:mt-0">
        @csrf
        @php $l = $model->so_detail_lembar ?? []; $done = $model->so_detail_kerja_status === 'Selesai'; @endphp

        {{-- Data Pelanggan --}}
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">badge</span> Data Pelanggan &amp; Alat
            </h3>
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-12 md:col-span-6">
                    <label class="font-body-sm font-bold text-on-surface-variant block mb-1">No Pesanan (SO)</label>
                    <input type="text" value="{{ $model->so?->so_code }}" readonly class="w-full h-12 px-4 bg-surface-container border border-outline-variant rounded-lg font-body-sm" />
                </div>
                <div class="col-span-12 md:col-span-6">
                    <label class="font-body-sm font-bold text-on-surface-variant block mb-1">Nama Alat</label>
                    <input type="text" value="{{ $model->product?->product_nama }}" readonly class="w-full h-12 px-4 bg-surface-container border border-outline-variant rounded-lg font-body-sm" />
                </div>
                @foreach([
                    'tempat' => 'Tempat Pelaksanaan', 'ruangan' => 'Ruangan',
                    'tanggal' => 'Tanggal Pelaksanaan', 'merek' => 'Merek',
                    'tipe' => 'Tipe', 'no_seri' => 'Nomor Seri',
                    'resolusi' => 'Resolusi', 'rentang' => 'Rentang',
                ] as $key => $label)
                    <div class="col-span-12 md:col-span-6">
                        <label class="font-body-sm font-bold text-on-surface-variant block mb-1">{{ $label }}</label>
                        <input type="{{ $key === 'tanggal' ? 'date' : 'text' }}" name="lembar[{{ $key }}]"
                            value="{{ $l[$key] ?? '' }}" @disabled($done)
                            class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" />
                    </div>
                @endforeach
                <div class="col-span-12 md:col-span-6">
                    <label class="font-body-sm font-bold text-on-surface-variant block mb-1">Jenis Alat</label>
                    <div class="relative">
                        <select name="lembar[jenis_alat]" @disabled($done)
                            class="w-full h-12 pl-4 pr-10 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none">
                            @foreach(['Analog', 'Digital'] as $opt)
                                <option value="{{ $opt }}" @selected(($l['jenis_alat'] ?? '') === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-xl">expand_more</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kondisi Lingkungan --}}
        <div class="bg-surface-container-lowest mt-5 border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">thermostat</span> Kondisi Lingkungan
            </h3>
            <div class="grid grid-cols-12 gap-5">
                @foreach([
                    'suhu_awal' => 'Suhu Awal (°C)', 'suhu_akhir' => 'Suhu Akhir (°C)',
                    'lembab_awal' => 'Kelembaban Awal (%RH)', 'lembab_akhir' => 'Kelembaban Akhir (%RH)',
                ] as $key => $label)
                    <div class="col-span-12 md:col-span-6">
                        <label class="font-body-sm font-bold text-on-surface-variant block mb-1">{{ $label }}</label>
                        <input type="text" name="lembar[{{ $key }}]" value="{{ $l[$key] ?? '' }}" @disabled($done)
                            class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pemeriksaan Fisik & Fungsi --}}
        <div class="bg-surface-container-lowest mt-5 border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">checklist</span> Pemeriksaan Fisik &amp; Fungsi
            </h3>
            <div class="grid grid-cols-12 gap-3">
                @foreach([
                    'badan' => 'Badan dan Permukaan Alat', 'kabel' => 'Kabel Catu Daya',
                    'sekering' => 'Sekering', 'kotak_kontak' => 'Kotak Kontak',
                    'tombol' => 'Tombol', 'indikator' => 'Tampilan dan Indikator',
                ] as $key => $label)
                    <div class="col-span-12 md:col-span-6 flex items-center justify-between border border-outline-variant rounded-lg px-4 py-2">
                        <span class="font-body-sm text-on-surface">{{ $label }}</span>
                        <div class="relative w-28">
                            <select name="lembar[fisik_{{ $key }}]" @disabled($done)
                                class="w-full h-10 pl-3 pr-8 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer outline-none">
                                @foreach(['✓' => 'Baik (✓)', 'X' => 'Tidak (X)', '-' => 'N/A (-)'] as $v => $t)
                                    <option value="{{ $v }}" @selected(($l['fisik_'.$key] ?? '✓') === $v)>{{ $t }}</option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-lg">expand_more</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Penilaian --}}
        <div class="bg-surface-container-lowest mt-5 border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">verified</span> Penilaian Menyeluruh
            </h3>
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-12 md:col-span-6">
                    <label class="font-body-sm font-bold text-on-surface-variant block mb-1">Kelaikan Alat</label>
                    <div class="relative">
                        <select name="lembar[penilaian]" @disabled($done)
                            class="w-full h-12 pl-4 pr-10 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer outline-none">
                            @foreach(['Baik digunakan', 'Tidak baik digunakan'] as $opt)
                                <option value="{{ $opt }}" @selected(($l['penilaian'] ?? 'Baik digunakan') === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-xl">expand_more</span>
                    </div>
                </div>
                <div class="col-span-12">
                    <label class="font-body-sm font-bold text-on-surface-variant block mb-1">Catatan Petugas</label>
                    <textarea name="lembar[catatan]" rows="3" @disabled($done)
                        class="w-full px-4 py-2 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none">{{ $l['catatan'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <x-action :model="null" :action="[]" :cancel="route('wms-pekerjaan.getTable')">
            @unless($done)
                <button type="submit" name="selesai" value="0"
                    class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-lg border border-outline-variant text-on-surface-variant text-sm font-semibold hover:bg-surface-container transition-all">
                    <span class="material-symbols-outlined text-xl">save</span> Simpan Draft
                </button>
                <button type="submit" name="selesai" value="1"
                    onclick="return confirm('Tandai selesai? Lembar kerja akan dikunci dan berita acara dibuat.')"
                    class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-lg bg-primary text-on-primary text-sm font-semibold hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-xl">task_alt</span> Selesai &amp; Buat Berita Acara
                </button>
            @else
                <a href="{{ route('wms-pekerjaan.getBeritaAcara', ['id' => $model->so_detail_id]) }}" target="_blank"
                    class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-lg border border-outline-variant text-on-surface-variant text-sm font-semibold hover:bg-surface-container transition-all">
                    <span class="material-symbols-outlined text-xl">description</span> Berita Acara
                </a>
                <a href="{{ route('wms-pekerjaan.getSertifikat', ['id' => $model->so_detail_id]) }}" target="_blank"
                    class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-lg bg-primary text-on-primary text-sm font-semibold hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-xl">workspace_premium</span> Print Sertifikat
                </a>
            @endunless
        </x-action>
    </form>
</x-layouts::app>
