<x-layouts::app title="Pengaturan Perusahaan">
    <x-breadcrumb :items="[['url' => route('dashboard'), 'label' => 'Dashboard'], ['url' => '', 'label' => 'Perusahaan']]" />

    <form action="{{ route('settings.company.save') }}" method="POST" enctype="multipart/form-data" class="mt-4 lg:mt-0">
        @csrf

        {{-- Logo --}}
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">image</span> Logo Perusahaan
            </h3>
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-12 md:col-span-3">
                    <div class="w-32 h-32 border border-outline-variant rounded-lg flex items-center justify-center bg-surface-container overflow-hidden">
                        @if($logo && file_exists(public_path($logo)))
                            <img src="{{ asset($logo) }}" alt="Logo" class="w-full h-full object-contain p-2">
                        @else
                            <span class="material-symbols-outlined text-on-surface-variant text-5xl">domain</span>
                        @endif
                    </div>
                </div>
                <div class="col-span-12 md:col-span-9">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Upload Logo</label>
                    <input type="file" name="logo" accept="image/png,image/jpeg,image/webp"
                        class="w-full px-4 py-2.5 bg-white border border-outline-variant rounded-lg font-body-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-primary file:text-on-primary file:text-sm file:cursor-pointer" />
                    <p class="font-label-caps text-label-caps text-on-surface-variant mt-1">PNG / JPG / WebP, maks 2 MB. Tampil di kop PDF.</p>
                    @error('logo')<p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Identitas --}}
        <div class="bg-surface-container-lowest mt-5 border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">business</span> Identitas Perusahaan
            </h3>
            <div class="grid grid-cols-12 gap-5">
                @foreach($fields as $key => $label)
                    <div class="col-span-12 md:col-span-6">
                        <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">{{ $label }}</label>
                        <input type="text" name="{{ $key }}" value="{{ old($key, $values[$key] ?? '') }}"
                            class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all" />
                        @error($key)<p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-surface-container-lowest mt-5 border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">palette</span>
                Warna Tema &amp; Dokumen
            </h3>
            <div class="grid grid-cols-12 gap-5">
                @foreach([
                    'THEME_PRIMARY' => 'Primary (Tombol/Aktif)',
                    'THEME_PRIMARY_CONTAINER' => 'Primary Container',
                    'THEME_SECONDARY' => 'Secondary',
                    'THEME_ON_PRIMARY' => 'Teks di Primary',
                    'THEME_ERROR' => 'Error / Danger',
                    'THEME_PDF_PRIMARY' => 'Warna Dokumen PDF (Sertifikat dll)',
                ] as $key => $label)
                    @php $cfgKey = strtolower(str_replace('THEME_', '', $key)); @endphp
                    <div class="col-span-12 md:col-span-6">
                        <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">{{ $label }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" value="{{ old($key, $themeValues[$key] ?? config('theme.'.$cfgKey)) }}"
                                oninput="this.nextElementSibling.value = this.value"
                                class="h-12 w-16 rounded-lg border border-outline-variant cursor-pointer bg-white p-1" />
                            <input type="text" name="{{ $key }}" value="{{ old($key, $themeValues[$key] ?? config('theme.'.$cfgKey)) }}"
                                oninput="this.previousElementSibling.value = this.value"
                                pattern="^#[0-9a-fA-F]{6}$" placeholder="#00288e"
                                class="flex-1 h-12 px-4 bg-white border border-outline-variant rounded-lg font-mono text-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" />
                        </div>
                        @error($key)<p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-outline-variant">
                <p class="font-label-caps text-label-caps text-on-surface-variant mb-2">Pratinjau:</p>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-primary text-on-primary text-sm font-semibold">
                        <span class="material-symbols-outlined text-lg">check</span> Tombol Primary
                    </span>
                    <span class="inline-flex items-center h-10 px-4 rounded-lg bg-primary-container text-on-primary text-sm">Primary Container</span>
                    <span class="inline-flex items-center h-10 px-4 rounded-lg bg-error text-on-error text-sm">Error</span>
                </div>
            </div>
        </div>

        <style>@media (min-width: 768px) { .action-bar { bottom: 0 !important; } }</style>
        <div class="action-bar fixed left-0 right-0 lg:left-72 bg-surface-container-lowest border-t border-outline-variant shadow-[0_-4px_12px_rgba(0,0,0,0.08)] px-4 md:px-6 py-3 z-[45]" style="bottom: 4rem">
            <div class="flex items-center justify-end max-w-full mx-auto gap-3">
                <x-button type="submit" icon="save">Simpan</x-button>
            </div>
        </div>
    </form>
</x-layouts::app>
