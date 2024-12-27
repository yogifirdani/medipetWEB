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
        'nama_produk',
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

     // Relasi dengan model Restock
     public function restocks()
    {
        return $this->hasMany(Restock::class, 'id_product');
    }

     // Fungsi untuk menambahkan stok setelah restock
     public function addStock($quantity)
     {
         $this->stok += $quantity; //tambah stok
         $this->save();
     }

     public function detail()//tambahan
     {
        return $this->hasMany(DetailOrder::class, 'id_product');
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
