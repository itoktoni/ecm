<?php /** @var App\Models\So $model */ ?>
@php
    $isEdit = isset($model) && $model->exists;
    $existingDetails = old('details');
    if ($existingDetails === null) {
    $existingDetails = $isEdit
        ? $model->details->map(fn ($d) => [
            'so_detail_id'       => $d->so_detail_id,
            'so_detail_id_jasa'  => $d->product?->product_id_jasa ?? '',
            'so_detail_id_product' => $d->so_detail_id_product,
            'so_detail_qty'      => $d->so_detail_qty,
            'so_detail_harga'    => $d->so_detail_harga,
            'so_detail_keterangan' => $d->so_detail_keterangan,
        ])->values()->all()
        : [['so_detail_id' => null, 'so_detail_id_jasa' => '', 'so_detail_id_product' => '', 'so_detail_qty' => 1, 'so_detail_harga' => '', 'so_detail_keterangan' => '']];
    }
@endphp

<x-layouts::app>
    <x-breadcrumb :items="[['url' => moduleRoute('getTable'), 'label' => ucfirst(module())], ['url' => '', 'label' => $isEdit ? 'Update' : 'Create']]" />

    <x-form :model="$model">
        <x-card :label="ucfirst(module())" icon="point_of_sale">
            @bind($model ?? null)
                @if($isEdit)
                    <x-input col="6" name="so_code" readonly />
                @endif
                <x-input :col="$isEdit ? 6 : 12" name="so_tanggal" type="date" />
                <x-select col="6" name="so_id_customer" label="Customer" :options="$customerOptions" class="search" />
                <x-select col="6" name="so_status" :options="$statusOptions" />
                <x-input col="12" name="so_keterangan" type="textarea" />
            @endbind
        </x-card>

        <x-card label="Detail Product &amp; Pajak" icon="inventory_2" class="mt-5" :noGrid="true">
            <livewire:so-details :rows="$existingDetails" :options="$productOptions->all()" :prices="$productPrices->all()"
                :jasa-options="$jasaOptions" :by-jasa="$byJasa"
                :so-ppn="old('so_ppn', $model?->so_ppn ?? 'none')"
                :so-ppn-rate="(int) old('so_ppn_rate', $model?->so_ppn_rate ?? 11)"
                :so-pph="old('so_pph', $model?->so_pph ?? 'no')"
                :so-pph-rate="(int) old('so_pph_rate', $model?->so_pph_rate ?? 2)"
                :so-discount="old('so_discount', $model?->so_discount ?? 0)"
                :so-discount-note="old('so_discount_note', $model?->so_discount_note ?? '')" />
            @error('details')
                <p class="font-label-caps text-label-caps text-error mt-2">{{ $message }}</p>
            @enderror
        </x-card>

        <x-action :model="$model" :action="['save']">
            @if($isEdit)
                <a href="{{ moduleRoute('getPrint', $model->so_id) }}" target="_blank"
                    class="inline-flex items-center justify-center gap-2 h-10 px-4 md:px-5 text-sm font-semibold rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-all">
                    <span class="material-symbols-outlined text-xl">print</span>
                    <span class="hidden sm:inline">Print</span>
                </a>
            @endif
        </x-action>
    </x-form>
</x-layouts::app>
