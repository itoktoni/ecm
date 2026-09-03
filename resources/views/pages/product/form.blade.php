<?php /** @var App\Models\Product $model */ ?>

<x-layouts::app>
    <x-breadcrumb :items="[['url' => moduleRoute('getTable'), 'label' => ucfirst(module())], ['url' => '', 'label' => isset($model) && $model->exists ? 'Update' : 'Create']]" />

    <x-form :model="$model">
        <x-card :label="ucfirst(module())">
            @bind($model ?? null)
                <x-input col="6" name="product_nama" />
                <x-select col="6" name="product_id_jasa" label="Jasa" :options="$jasaOptions" class="search" />
                <x-input col="6" name="product_harga" type="number" helper="Kosongkan untuk jasa Perbaikan (harga manual)" />
                <x-input col="6" name="product_ekatalog" type="url" label="Link E-Katalog" helper="Link ke katalog.inaproc.id sesuai price list" />
            @endbind
        </x-card>

        <x-action :model="$model" :action="['save']"/>
    </x-form>
</x-layouts::app>
