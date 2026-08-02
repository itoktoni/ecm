<?php

use App\Models\So;
use App\Models\SoDetail;
use Livewire\Component;

new class extends Component {
    public int $soId;
    public array $rows = [];
    public bool $saved = false;

    public function mount(int $soId): void
    {
        $this->soId = $soId;
        $this->load();
    }

    private function load(): void
    {
        $so = So::with('details.product')->findOrFail($this->soId);

        $this->rows = $so->details->map(fn (SoDetail $d) => [
            'id'          => $d->so_detail_id,
            'nama'        => $d->product?->product_nama ?? '-',
            'qty'         => (int) $d->so_detail_qty,
            'a'           => (bool) $d->so_detail_kaji_a,
            'b'           => (bool) $d->so_detail_kaji_b,
            'c'           => (bool) $d->so_detail_kaji_c,
            'd'           => (bool) $d->so_detail_kaji_d,
            'keterangan'  => $d->so_detail_kaji_keterangan ?? '',
        ])->values()->all();
    }

    public function save(): void
    {
        foreach ($this->rows as $row) {
            SoDetail::where('so_detail_id', $row['id'])->update([
                'so_detail_kaji_a'          => (bool) $row['a'],
                'so_detail_kaji_b'          => (bool) $row['b'],
                'so_detail_kaji_c'          => (bool) $row['c'],
                'so_detail_kaji_d'          => (bool) $row['d'],
                'so_detail_kaji_keterangan' => $row['keterangan'] !== '' ? $row['keterangan'] : null,
            ]);
        }

        $this->saved = true;
        $this->dispatch('kaji-saved');
    }
}; ?>

<div>
    @if($saved)
        <div class="mb-4 flex items-center gap-2 rounded-lg border border-primary bg-primary/10 px-4 py-3 text-primary font-body-sm">
            <span class="material-symbols-outlined">check_circle</span>
            Kaji ulang tersimpan.
        </div>
    @endif

    <div class="space-y-3">
        @forelse($rows as $i => $row)
            <div wire:key="kaji-{{ $row['id'] }}"
                class="border border-outline-variant rounded-lg p-4 bg-surface-container-low">
                <div class="grid grid-cols-12 gap-4 items-start">
                    <div class="col-span-12 md:col-span-4">
                        <div class="font-body-sm font-bold text-on-surface">{{ $i + 1 }}. {{ $row['nama'] }}</div>
                        <div class="font-label-caps text-label-caps text-on-surface-variant mt-1">Qty: {{ $row['qty'] }}</div>

                        <div class="flex flex-wrap gap-3 mt-3">
                            @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" wire:model="rows.{{ $i }}.{{ $key }}"
                                        class="h-5 w-5 rounded border-outline-variant text-primary focus:ring-primary-container" />
                                    <span class="font-body-sm font-bold text-on-surface">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-8">
                        <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Keterangan</label>
                        <textarea wire:model="rows.{{ $i }}.keterangan" rows="2"
                            class="w-full px-4 py-2 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                            placeholder="cth: kondisi peralatan tidak memadai, akan di-subkontrak ke PT. A"></textarea>
                    </div>
                </div>
            </div>
        @empty
            <p class="font-body-sm text-on-surface-variant italic">Belum ada item pada Sales Order ini.</p>
        @endforelse
    </div>

    <div class="mt-4 rounded-lg border border-outline-variant p-4 bg-surface-container-low font-label-caps text-label-caps text-on-surface-variant">
        <div class="font-bold text-on-surface mb-1">Keterangan Kaji Ulang:</div>
        <div>A. Kesiapan Personel Kalibrasi &nbsp;|&nbsp; B. Kondisi Peralatan &nbsp;|&nbsp; C. Metode Kerja &nbsp;|&nbsp; D. Lainnya</div>
    </div>

    @if(count($rows))
        <div class="flex justify-end mt-4">
            <button type="button" wire:click="save"
                class="inline-flex items-center gap-2 h-10 px-5 rounded-lg bg-primary text-on-primary font-body-sm font-semibold hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan Kaji Ulang
            </button>
        </div>
    @endif
</div>
