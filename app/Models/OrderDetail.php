<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'order_detail_id';
    public $incrementing = true;

    protected $fillable = [
        'order_id', 'product_id', 'product_nama',
        'product_harga', 'quantity', 'subtotal',
    ];

    protected $casts = [
        'product_harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
