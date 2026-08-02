<?php /** @var App\Models\So $model */ ?>

<x-layouts::app>
    <x-breadcrumb :items="[['url' => moduleRoute('getTable'), 'label' => ucfirst(module())], ['url' => moduleRoute('getUpdate', $model->so_id), 'label' => $model->so_code], ['url' => '', 'label' => 'Kaji Ulang']]" />

    <x-card label="Form Kaji Ulang Permintaan Kalibrasi" icon="fact_check" :noGrid="true">
        <div class="grid grid-cols-12 gap-4 mb-5 font-body-sm">
            <div class="col-span-12 md:col-span-6">
                <span class="text-on-surface-variant">Pemesan:</span>
                <span class="font-bold text-on-surface">{{ $model->customer?->customer_nama ?? '-' }}</span>
            </div>
            <div class="col-span-12 md:col-span-6">
                <span class="text-on-surface-variant">Nomor SO:</span>
                <span class="font-bold text-on-surface">{{ $model->so_code }}</span>
            </div>
            <div class="col-span-12">
                <span class="text-on-surface-variant">Lokasi:</span>
                <span class="text-on-surface">{{ $model->customer?->customer_alamat ?? '-' }}</span>
            </div>
        </div>

        <livewire:so-kaji-ulang :so-id="$model->so_id" />
    </x-card>

    <x-action :model="$model" :action="[]" :cancel="moduleRoute('getUpdate', $model->so_id)">
        <a href="{{ moduleRoute('getPenawaran', $model->so_id) }}" target="_blank"
            class="inline-flex items-center justify-center gap-2 h-10 px-4 md:px-5 text-sm font-semibold rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-all">
            <span class="material-symbols-outlined text-xl">request_quote</span>
            <span class="hidden sm:inline">Penawaran</span>
        </a>
    </x-action>
</x-layouts::app>
