<?php

use App\Models\So;
use Livewire\Component;

new class extends Component {
    public array $rows = [];
    public array $options = [];
    public array $prices = [];
    public array $jasaOptions = [];
    public array $byJasa = [];

    public string $soPpn = 'none';
    public int $soPpnRate = 11;
    public string $soPph = 'no';
    public int $soPphRate = 2;
    public string $soDiscount = '0';
    public string $soDiscountNote = '';

    public function mount(array $rows = [], array $options = [], array $prices = [], array $jasaOptions = [], array $byJasa = [], ?string $soPpn = null, ?int $soPpnRate = null, ?string $soPph = null, ?int $soPphRate = null, ?string $soDiscount = null, ?string $soDiscountNote = null): void
    {
        $this->options = $options;
        $this->prices = $prices;
        $this->jasaOptions = $jasaOptions;
        $this->byJasa = $byJasa;
        $this->rows = $rows ?: [$this->blank()];
        $this->soPpn = $soPpn ?? 'none';
        $this->soPpnRate = $soPpnRate ?? 11;
        $this->soPph = $soPph ?? 'no';
        $this->soPphRate = $soPphRate ?? 2;
        $this->soDiscount = $soDiscount ?? '0';
        $this->soDiscountNote = $soDiscountNote ?? '';
    }

    public function addRow(): void
    {
        $this->rows[] = $this->blank();
    }

    public function removeRow(int $i): void
    {
        unset($this->rows[$i]);
        $this->rows = array_values($this->rows) ?: [$this->blank()];
    }

    public function updated(string $property): void
    {
        // Changing jasa clears product + harga (filtered list is invalid).
        if (preg_match('/^rows\.(\d+)\.so_detail_id_jasa$/', $property, $m)) {
            $i = (int) $m[1];
            $this->rows[$i]['so_detail_id_product'] = '';
            $this->rows[$i]['so_detail_harga'] = '';

            return;
        }

        if (! preg_match('/^rows\.(\d+)\.so_detail_id_product$/', $property, $m)) {
            return;
        }

        $i = (int) $m[1];
        $product = $this->rows[$i]['so_detail_id_product'] ?? '';
        if ($product === '' || $product === null) {
            return;
        }

        foreach ($this->rows as $j => $row) {
            if ($j === $i || (string) $row['so_detail_id_product'] !== (string) $product) {
                continue;
            }

            $this->rows[$i]['so_detail_id_product'] = '';
            $this->addError($property, 'Product '.($this->options[$product] ?? $product).' sudah ada di data.');

            return;
        }

        // Auto-fill harga from product master when the row has none (editable for perbaikan).
        if (($this->rows[$i]['so_detail_harga'] ?? '') === '') {
            $h = $this->prices[$product] ?? '';
            $this->rows[$i]['so_detail_harga'] = ($h === '' || $h === null) ? '' : (string) $h;
        }
    }

    /** Product ids already used by rows other than $i. */
    public function takenBy(int $i): array
    {
        return collect($this->rows)
            ->except($i)
            ->pluck('so_detail_id_product')
            ->filter(fn ($v) => $v !== '' && $v !== null)
            ->map(fn ($v) => (string) $v)
            ->values()
            ->all();
    }

    /** Options (product => nama) for a single row, filtered by its jasa. */
    public function optionsFor(int $i): array
    {
        $jasa = (string) ($this->rows[$i]['so_detail_id_jasa'] ?? '');

        if ($jasa === '') {
            // byJasa present: only unassigned products (key 0); legacy: full options.
            return $this->byJasa !== []
                ? ($this->byJasa[0] ?? [])
                : $this->options;
        }

        return $this->byJasa[$jasa] ?? [];
    }

    public function priceOf(int $i): float
    {
        $row = $this->rows[$i];
        $harga = $row['so_detail_harga'] ?? '';

        if ($harga !== '' && $harga !== null) {
            return (float) $harga;
        }

        $product = $row['so_detail_id_product'] ?? '';

        return (float) ($this->prices[$product] ?? 0);
    }

    public function getTotalProperty(): float
    {
        $total = 0.0;
        foreach ($this->rows as $i => $row) {
            $total += $this->priceOf($i) * (int) ($row['so_detail_qty'] ?: 0);
        }

        return $total;
    }

    public function getSummaryProperty(): array
    {
        return So::calculateTotals(
            $this->total,
            (float) $this->soDiscount,
            $this->soPpn,
            $this->soPpnRate,
            $this->soPph,
            $this->soPphRate
        );
    }

    // ponytail: no validation here — SoController validates via So::rules() on submit.
    private function blank(): array
    {
        return [
            'so_detail_id'         => null,
            'so_detail_id_jasa'    => '',
            'so_detail_id_product' => '',
            'so_detail_qty'        => 1,
            'so_detail_harga'      => '',
            'so_detail_keterangan' => '',
        ];
    }
}; ?>

<div>
    <div class="space-y-3">
        @foreach($rows as $i => $row)
            <div wire:key="so-row-{{ $i }}"
                class="grid grid-cols-12 gap-3 items-end border border-outline-variant rounded-lg p-3 bg-surface-container-low">
                <input type="hidden" name="details[{{ $i }}][so_detail_id]" value="{{ $row['so_detail_id'] }}" />
                <div class="col-span-12 md:col-span-4">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Jasa</label>
                    <div class="relative">
                        <select name="details[{{ $i }}][so_detail_id_jasa]"
                            wire:model.live="rows.{{ $i }}.so_detail_id_jasa"
                            class="w-full h-12 pl-4 pr-10 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none">
                            <option value="">-- Silahkan Pilih --</option>
                            @foreach($jasaOptions as $id => $nama)
                                <option value="{{ $id }}"
                                    @selected((string) ($row['so_detail_id_jasa'] ?? '') === (string) $id)>{{ $nama }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-xl">expand_more</span>
                    </div>
                    @error("rows.$i.so_detail_id_jasa")
                        <p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-span-12 md:col-span-4">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Product</label>
                    <div class="relative">
                        <select name="details[{{ $i }}][so_detail_id_product]"
                            wire:model.live="rows.{{ $i }}.so_detail_id_product"
                            class="w-full h-12 pl-4 pr-10 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                            required>
                            <option value="">-- Silahkan Pilih --</option>
                            @foreach($this->optionsFor($i) as $id => $nama)
                                <option value="{{ $id }}"
                                    @selected((string) $row['so_detail_id_product'] === (string) $id)
                                    @disabled(in_array((string) $id, $this->takenBy($i), true))>{{ $nama }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-xl">expand_more</span>
                    </div>
                    @error("rows.$i.so_detail_id_product")
                        <p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-span-12 md:col-span-4">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Harga</label>
                    <input type="number" min="0" step="1" name="details[{{ $i }}][so_detail_harga]"
                        wire:model.live="rows.{{ $i }}.so_detail_harga"
                        class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                        placeholder="auto / manual" />
                </div>
                <div class="col-span-6 md:col-span-2">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Qty</label>
                    <input type="number" min="1" name="details[{{ $i }}][so_detail_qty]"
                        wire:model.live="rows.{{ $i }}.so_detail_qty"
                        class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                        required />
                </div>
                <div class="col-span-6 md:col-span-4">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Keterangan</label>
                    <input type="text" name="details[{{ $i }}][so_detail_keterangan]"
                        wire:model.live="rows.{{ $i }}.so_detail_keterangan"
                        class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                        placeholder="cth: sertifikat / kalibrasi ulang" />
                </div>
                <div class="col-span-6 md:col-span-3">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Subtotal</label>
                    <div class="h-12 px-4 flex items-center rounded-lg bg-surface-container font-body-sm text-on-surface">
                        {{ formatAngka((int) round($this->priceOf($i) * (int) ($row['so_detail_qty'] ?: 0)), 'Rp ') }}
                    </div>
                </div>
                <div class="col-span-6 md:col-span-3 flex justify-end">
                    <button type="button" wire:click="removeRow({{ $i }})" title="Hapus"
                        class="inline-flex items-center justify-center h-12 w-12 rounded-lg border border-error text-error hover:bg-error hover:text-on-error transition-colors">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-5 space-y-4 border border-outline-variant rounded-lg p-4 bg-surface-container-low">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">PPN (Mode)</label>
                <div class="relative">
                    <select name="so_ppn" wire:model.live="soPpn"
                        class="w-full h-12 pl-4 pr-10 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none">
                        @foreach (So::ppnOptions() as $key => $text)
                            <option value="{{ $key }}" @selected($this->soPpn === $key)>{{ $text }}</option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-xl">expand_more</span>
                </div>
                @error('so_ppn')
                    <p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">PPN Rate (%)</label>
                <input type="number" min="0" name="so_ppn_rate" wire:model.live="soPpnRate"
                    class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" />
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">PPH (Mode)</label>
                <div class="relative">
                    <select name="so_pph" wire:model.live="soPph"
                        class="w-full h-12 pl-4 pr-10 bg-white border border-outline-variant rounded-lg font-body-sm appearance-none cursor-pointer focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none">
                        @foreach (So::pphOptions() as $key => $text)
                            <option value="{{ $key }}" @selected($this->soPph === $key)>{{ $text }}</option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-xl">expand_more</span>
                </div>
                @error('so_pph')
                    <p class="font-label-caps text-label-caps text-error mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">PPH Rate (%)</label>
                <input type="number" min="0" name="so_pph_rate" wire:model.live="soPphRate"
                    class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" />
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Discount</label>
                <input type="number" min="0" step="1" name="so_discount" wire:model.live="soDiscount"
                    class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" />
            </div>
            <div>
                <label class="font-body-sm text-body-sm font-bold text-on-surface-variant block mb-1">Keterangan Discount</label>
                <input type="text" name="so_discount_note" wire:model="soDiscountNote"
                    class="w-full h-12 px-4 bg-white border border-outline-variant rounded-lg font-body-sm focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                    placeholder="cth: discount 20% pembelian 10 item" />
            </div>
        </div>
    </div>

    <div class="mt-4 border border-outline-variant rounded-lg p-4 bg-surface-container-low">
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Subtotal</p>
                <p class="font-body-lg text-body-lg text-on-surface">{{ formatAngka((int) round($this->summary['subtotal']), 'Rp ') }}</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Discount</p>
                <p class="font-body-lg text-body-lg text-error">{{ formatAngka((int) round($this->summary['discount']), '- Rp ') }}</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-body-sm text-body-sm text-on-surface-variant">DPP</p>
                <p class="font-body-lg text-body-lg text-on-surface">{{ formatAngka((int) round($this->summary['dpp']), 'Rp ') }}</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-body-sm text-body-sm text-on-surface-variant">PPN ({{ $this->soPpnRate }}%)</p>
                <p class="font-body-lg text-body-lg text-on-surface">{{ formatAngka((int) round($this->summary['ppn']), 'Rp ') }}</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="font-body-sm text-body-sm text-on-surface-variant">PPH ({{ $this->soPphRate }}%)</p>
                <p class="font-body-lg text-body-lg text-on-surface">{{ formatAngka((int) round($this->summary['pph']), 'Rp ') }}</p>
            </div>
            <div class="flex items-center justify-between border-t border-outline-variant pt-3">
                <p class="font-body-lg text-body-lg font-bold text-on-surface">Grand Total</p>
                <p class="font-headline-md text-headline-md text-primary">{{ formatAngka((int) round($this->summary['grand_total']), 'Rp ') }}</p>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="button" wire:click="addRow"
            class="inline-flex items-center gap-1.5 h-10 px-4 rounded-lg bg-primary text-on-primary font-body-sm hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Product
        </button>
    </div>
</div>
