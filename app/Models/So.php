<?php

namespace App\Models;

class So extends BaseModel
{
    protected $table = 'so';

    protected $primaryKey = 'so_id';

    public $timestamps = true;

    const STATUS_PENDING = 'Pending';

    const STATUS_CONFIRMED = 'Confirmed';

    const STATUS_SHIPPED = 'Shipped';

    const STATUS_CLOSED = 'Closed';

    public static $filterColumns = ['so_code', 'so_id_customer', 'so_tanggal', 'so_status'];

    public static $sortColumns = ['so_code', 'so_tanggal', 'so_status'];

    protected $fillable = [
        'so_tanggal',
        'so_code',
        'so_id_customer',
        'so_status',
        'so_keterangan',
        'so_pph',
        'so_pph_rate',
        'so_ppn',
        'so_ppn_rate',
        'so_discount',
        'so_discount_note',
    ];

    protected $attributes = [
        'so_status' => self::STATUS_PENDING,
        'so_pph' => 'no',
        'so_pph_rate' => 2,
        'so_ppn' => 'none',
        'so_ppn_rate' => 11,
        'so_discount' => 0,
    ];

    protected $casts = [
        'so_tanggal' => 'date',
        'so_pph_rate' => 'integer',
        'so_ppn_rate' => 'integer',
        'so_discount' => 'decimal:0',
    ];

    public function details()
    {
        return $this->hasMany(SoDetail::class, 'so_detail_id_so', 'so_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'so_id_customer', 'customer_id');
    }

    protected static function booted(): void
    {
        static::creating(function (self $so) {
            if (empty($so->so_code)) {
                $so->so_code = self::generateCode();
            }
        });
    }

    public static function generateCode(): string
    {
        do {
            $code = 'SO-'.now()->format('Ymd').'-'.unic_number(4);
        } while (self::where('so_code', $code)->exists());

        return $code;
    }

    public static function customerOptions(): array
    {
        return Customer::pluck('customer_nama', 'customer_id')->all();
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => self::STATUS_PENDING,
            self::STATUS_CONFIRMED => self::STATUS_CONFIRMED,
            self::STATUS_SHIPPED => self::STATUS_SHIPPED,
            self::STATUS_CLOSED => self::STATUS_CLOSED,
        ];
    }

    public static function pphOptions(): array
    {
        return [
            'include' => 'Include',
            'exclude' => 'Exclude',
            'no' => 'No',
        ];
    }

    public static function ppnOptions(): array
    {
        return [
            'include' => 'Include',
            'exclude' => 'Exclude',
            'none' => 'None',
        ];
    }

    public function getSoTotalAttribute(): string
    {
        $details = $this->relationLoaded('details') ? $this->details : $this->details()->get();

        return (string) $details->sum(fn ($d) => (int) $d->so_detail_qty * (float) $d->so_detail_harga);
    }

    public function getSoSubtotalAttribute(): float
    {
        return (float) $this->so_total;
    }

    public function getSoDppAttribute(): float
    {
        return max(0, $this->so_subtotal - (float) $this->so_discount);
    }

    public function getSoPpnAmountAttribute(): float
    {
        return self::calculateTotals(
            $this->so_subtotal,
            (float) $this->so_discount,
            $this->so_ppn,
            (int) $this->so_ppn_rate,
            $this->so_pph,
            (int) $this->so_pph_rate
        )['ppn'];
    }

    public function getSoPphAmountAttribute(): float
    {
        return self::calculateTotals(
            $this->so_subtotal,
            (float) $this->so_discount,
            $this->so_ppn,
            (int) $this->so_ppn_rate,
            $this->so_pph,
            (int) $this->so_pph_rate
        )['pph'];
    }

    public function getSoGrandTotalAttribute(): float
    {
        return self::calculateTotals(
            $this->so_subtotal,
            (float) $this->so_discount,
            $this->so_ppn,
            (int) $this->so_ppn_rate,
            $this->so_pph,
            (int) $this->so_pph_rate
        )['grand_total'];
    }

    /**
     * Shared tax/discount math used by both model accessors and the Livewire form.
     * B semantics: exclude = tax on top, include = price already contains tax.
     */
    public static function calculateTotals(float $subtotal, float $discount, string $ppnMode, int $ppnRate, string $pphMode, int $pphRate): array
    {
        $dpp = max(0, $subtotal - $discount);

        $ppn = match ($ppnMode) {
            'exclude' => $dpp * $ppnRate / 100,
            'include' => $dpp * $ppnRate / (100 + $ppnRate),
            default => 0,
        };

        $pph = match ($pphMode) {
            'exclude' => $dpp * $pphRate / 100,
            'include' => $dpp * $pphRate / (100 + $pphRate),
            default => 0,
        };

        $grandTotal = $dpp
            + ($ppnMode === 'exclude' ? $ppn : 0)
            + ($pphMode === 'exclude' ? $pph : 0);

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'dpp' => $dpp,
            'ppn' => $ppn,
            'pph' => $pph,
            'grand_total' => $grandTotal,
        ];
    }

    public function rules(): array
    {
        return [
            'so_code' => ['nullable', 'string', 'max:50'],
            'so_tanggal' => ['required', 'date'],
            'so_id_customer' => ['required', 'integer', 'exists:customer,customer_id'],
            'so_status' => ['nullable', 'string', 'in:Pending,Confirmed,Shipped,Closed'],
            'so_keterangan' => ['nullable', 'string'],
            'so_pph' => ['nullable', 'string', 'in:include,exclude,no'],
            'so_pph_rate' => ['nullable', 'integer', 'min:0'],
            'so_ppn' => ['nullable', 'string', 'in:include,exclude,none'],
            'so_ppn_rate' => ['nullable', 'integer', 'min:0'],
            'so_discount' => ['nullable', 'numeric', 'min:0'],
            'so_discount_note' => ['nullable', 'string', 'max:255'],
            'details' => ['required', 'array', 'min:1'],
            'details.*.so_detail_id' => ['nullable', 'integer'],
            'details.*.so_detail_id_jasa' => ['nullable', 'integer', 'exists:jasa,jasa_id'],
            'details.*.so_detail_id_product' => ['required', 'integer', 'exists:product,product_id'],
            'details.*.so_detail_qty' => ['required', 'integer', 'min:1'],
            'details.*.so_detail_harga' => ['nullable', 'numeric', 'min:0'],
            'details.*.so_detail_keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
