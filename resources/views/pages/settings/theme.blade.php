<x-layouts::app title="Pengaturan Tema">
    <x-breadcrumb :items="[['url' => route('dashboard'), 'label' => 'Dashboard'], ['url' => '', 'label' => 'Tema & Warna']]" />

    <form action="{{ route('settings.theme.save') }}" method="POST" class="mt-4 lg:mt-0">
        @csrf

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 form-card">
            <h3 class="font-headline-md text-headline-md text-on-surface pb-4 mb-4 border-b border-outline-variant flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">palette</span> Warna Aplikasi &amp; Dokumen
            </h3>
            <div class="grid grid-cols-12 gap-5">
                @foreach($fields as $key => [$label, $cfg])
                    <div class="col-span-12 md:col-span-6">
                        <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">{{ $label }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" value="{{ old($key, $values[$key] ?? '#000000') }}"
                                oninput="this.nextElementSibling.value = this.value"
                                class="h-12 w-16 rounded-lg border border-outline-variant cursor-pointer bg-white p-1" />
                            <input type="text" name="{{ $key }}" value="{{ old($key, $values[$key] ?? '') }}"
                                oninput="this.previousElementSibling.value = this.value"
                                pattern="^#[0-9a-fA-F]{6}$" placeholder="#00288e"
                                class="flex-1 h-12 px-4 bg-white border border-outline-variant rounded-lg font-mono text-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" />
                        </div>
                        @error($key)<p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-4 border-t border-outline-variant">
                <p class="font-body-sm text-on-surface-variant mb-3">Pratinjau:</p>
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
                <x-button type="submit" icon="save">Simpan Tema</x-button>
            </div>
        </div>
    </form>
</x-layouts::app>
