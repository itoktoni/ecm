<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $incrementing = true;

    protected $fillable = [
        'order_no', 'user_id', 'customer_nama', 'customer_email',
        'customer_telepon', 'customer_alamat', 'order_subtotal',
        'order_tax', 'order_discount', 'order_total', 'order_status',
        'order_tanggal', 'order_tanggal_kirim', 'order_catatan', 'order_so_id',
        'order_ppn', 'order_ppn_rate', 'order_ppn_amount',
        'order_pph', 'order_pph_rate', 'order_pph_amount',
        'order_discount', 'order_discount_note',
    ];

    protected $casts = [
        'order_subtotal' => 'decimal:2',
        'order_tax' => 'decimal:2',
        'order_discount' => 'decimal:2',
        'order_total' => 'decimal:2',
        'order_tanggal' => 'date',
        'order_tanggal_kirim' => 'date',
        'order_discount_note' => 'string',
        'order_ppn' => 'string',
        'order_ppn_rate' => 'integer',
        'order_ppn_amount' => 'decimal:2',
        'order_pph' => 'string',
        'order_pph_rate' => 'integer',
        'order_pph_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Generate nomor order otomatis (auto-increment integer).
     */
    public static function generateNo(): int
    {
        $last = self::withoutTrashed()->max('order_no') ?? 100000;

        return (int) $last + 1;
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id')
                    ->with('product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * SO (sales order) yang dihasilkan dari order ini, jika sudah dikonversi.
     */
    public function so()
    {
        return $this->belongsTo(So::class, 'order_so_id', 'so_id');
    }

    /**
     * Rekap order untuk ditampilkan di frontend (list / detail).
     */
    public function getProductList(): string
    {
        $names = $this->details->map(fn ($d) => $d->product_nama . ' (' . $d->quantity . ')')->implode(', ');

        return $names ?: '-';
    }

    public function getStatusLabel(): string
    {
        $labels = [
            'draft' => 'Draft',
            'pending' => 'Menunggu Konfirmasi',
            'processing' => 'Diproses',
            'shipping' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$this->order_status] ?? $this->order_status;
    }
}
