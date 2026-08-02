<?php

namespace App\Models;

class SoDetail extends BaseModel
{
    protected $table = 'detail_so';

    protected $primaryKey = 'so_detail_id';

    public $timestamps = true;

    public static $filterColumns = ['so_detail_code', 'so_detail_id_product', 'so_detail_id_so'];

    public static $sortColumns = ['so_detail_code', 'so_detail_qty', 'so_detail_harga'];

    protected $fillable = [
        'so_detail_id_so',
        'so_detail_id_product',
        'so_detail_qty',
        'so_detail_harga',
        'so_detail_keterangan',
        'so_detail_code',
        'so_detail_kaji_a',
        'so_detail_kaji_b',
        'so_detail_kaji_c',
        'so_detail_kaji_d',
        'so_detail_kaji_keterangan',
        'so_detail_id_teknisi',
        'so_detail_kerja_status',
        'so_detail_kerja_ambil_at',
        'so_detail_kerja_selesai_at',
        'so_detail_lembar',
        'so_detail_sertifikat_no',
    ];

    protected $casts = [
        'so_detail_qty' => 'integer',
        'so_detail_harga' => 'decimal:0',
        'so_detail_kaji_a' => 'boolean',
        'so_detail_kaji_b' => 'boolean',
        'so_detail_kaji_c' => 'boolean',
        'so_detail_kaji_d' => 'boolean',
        'so_detail_kerja_ambil_at' => 'datetime',
        'so_detail_kerja_selesai_at' => 'datetime',
        'so_detail_lembar' => 'array',
    ];

    const KERJA_TERSEDIA = 'Tersedia';

    const KERJA_DIAMBIL = 'Diambil';

    const KERJA_SELESAI = 'Selesai';

    public function so()
    {
        return $this->belongsTo(So::class, 'so_detail_id_so', 'so_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'so_detail_id_product', 'product_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'so_detail_id_teknisi', 'id');
    }
}
