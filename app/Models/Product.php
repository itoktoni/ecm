<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    public $timestamps = true;

    public static $filterColumns = ['product_nama', 'product_id_jasa'];

    public static $sortColumns = ['product_id', 'product_nama', 'product_harga'];

    protected $fillable = [
        'product_nama',
        'product_id_jasa',
        'product_harga',
    ];

    protected $casts = [
        'product_id_jasa' => 'integer',
        'product_harga' => 'decimal:0',
    ];

    public function jasa()
    {
        return $this->belongsTo(Jasa::class, 'product_id_jasa', 'jasa_id');
    }

    public function getJasaNamaAttribute()
    {
        return $this->relationLoaded('jasa') ? ($this->jasa->jasa_nama ?? '-') : ($this->jasa()->value('jasa_nama') ?? '-');
    }

    public function rules(): array
    {
        return [
            'product_nama' => ['required', 'string', 'max:200'],
            'product_id_jasa' => ['nullable', 'integer', 'exists:jasa,jasa_id'],
            'product_harga' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function stock()
    {
        return $this->hasMany(Stock::class, 'stock_id_product', 'product_id');
    }

    public function getQtyAttribute()
    {
        return $this->relationLoaded('stock') ? $this->stock->sum('stock_qty') : $this->stock()->sum('stock_qty');
    }

    public function getTanggalAttribute()
    {
        return $this->relationLoaded('stock')
            ? optional($this->stock->sortByDesc('stock_expired_date')->first())->stock_expired_date
            : $this->stock()->max('stock_expired_date');
    }
}
