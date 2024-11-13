<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    use HasFactory;

    protected $table = "restocks";
    protected $primaryKey = 'id_restock';
    protected $fillable = [
        'id_product',
        'nama_produk',
        'quantity',
        'harga_satuan',
        'total_harga',
        'tanggal_pembelian',
        'supplier',
    ];


    // Relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
