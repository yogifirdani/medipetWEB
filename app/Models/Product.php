<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product";
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'jenis_hewan',
        'kategori',
        'merek',
        'berat',
        'stok',
        'harga',
        'deskripsi',
        'image',
        'kadaluarsa',
    ];

    public static function jmlProduk()
    {
        return self::count();
    }

    // public static function jmlStok($category)
    // {
    //     return self::where('category', $category)->sum('stok');
    // }

    // public static function jmlProduk()
    // {
    //     return self::where('category', 'item')->count();
    // }

    // public function getQuantityAttribute()
    // {
    //     return $this->stok;
    // }

    // public function getTotalPriceAttribute()
    // {
    //     return $this->stok * $this->price;
    // }

    // public function getPriceAttribute()
    // {
    //     return $this->attributes['price'];
    // }

}
