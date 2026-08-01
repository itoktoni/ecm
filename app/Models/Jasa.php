<?php

namespace App\Models;

class Jasa extends BaseModel
{
    protected $table = 'jasa';

    protected $primaryKey = 'jasa_id';

    public $timestamps = true;

    public static $filterColumns = ['jasa_nama', 'jasa_icon'];

    public static $sortColumns = ['jasa_nama', 'jasa_icon'];

    protected $fillable = [
        'jasa_nama',
        'jasa_icon',
    ];

    public static function field_name()
    {
        return 'jasa_nama';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id_jasa', 'jasa_id');
    }

    public function getProductCountAttribute(): int
    {
        return $this->relationLoaded('products') ? $this->products->count() : $this->products()->count();
    }

    public function rules(): array
    {
        return [
            'jasa_nama' => ['required', 'string', 'max:100', 'unique:jasa,jasa_nama,'.($this->jasa_id ?? '')],
            'jasa_icon' => ['nullable', 'string', 'max:50'],
        ];
    }

    public static function jasaOptions(): array
    {
        return self::pluck('jasa_nama', 'jasa_id')->all();
    }
}
