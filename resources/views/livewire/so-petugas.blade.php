<?php

use App\Models\User;
use Livewire\Component;

new class extends Component {
    public array $options = [];
    public array $selected = [];
    public string $pick = '';

    public function mount(array $options = [], array $selected = []): void
    {
        $this->options = $options;
        $this->selected = array_values(array_unique(array_map('strval', $selected)));
    }

    public function add(): void
    {
        $id = trim($this->pick);
        if ($id === '' || in_array($id, $this->selected, true) || ! isset($this->options[$id])) {
            $this->pick = '';

            return;
        }

        $this->selected[] = $id;
        $this->pick = '';
    }

    public function remove(string $id): void
    {
        $this->selected = array_values(array_filter($this->selected, fn ($s) => $s !== $id));
    }

    public function with(): array
    {
        $available = array_filter($this->options, fn ($nama, $id) => ! in_array((string) $id, $this->selected, true), ARRAY_FILTER_USE_BOTH);

        return ['available' => $available];
    }
}; ?>

<div>
    @foreach($selected as $id)
        <input type="hidden" name="petugas[]" value="{{ $id }}" />
    @endforeach

    <div class="flex items-end gap-3">
        <div class="flex-1">
            <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Petugas / Teknisi</label>
            <div class="relative">
                <select wire:model="pick"
                    class="w-full h-12 pl-4 pr-10 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none">
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($available as $id => $nama)
                        <option value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                </select>
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-xl">expand_more</span>
            </div>
        </div>
        <button type="button" wire:click="add"
            class="inline-flex items-center gap-1.5 h-12 px-4 rounded-lg bg-primary text-on-primary font-body-sm hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah
        </button>
    </div>

    <div class="mt-4 space-y-2">
        @forelse($selected as $id)
            <div wire:key="petugas-{{ $id }}"
                class="flex items-center justify-between border border-outline-variant rounded-lg px-4 py-3 bg-surface-container-low">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">badge</span>
                    <span class="font-body-sm text-on-surface">{{ $options[$id] ?? 'User #'.$id }}</span>
                </div>
                <button type="button" wire:click="remove('{{ $id }}')" title="Hapus"
                    class="inline-flex items-center justify-center h-9 w-9 rounded-lg border border-error text-error hover:bg-error hover:text-on-error transition-colors">
                    <span class="material-symbols-outlined text-lg">delete</span>
                </button>
            </div>
        @empty
            <p class="font-body-sm text-on-surface-variant italic">Belum ada petugas. Pilih user lalu klik Tambah.</p>
        @endforelse
    </div>
</div>
