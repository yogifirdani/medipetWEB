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
        'id_supplier',
        'nama_produk',
        'quantity',
        'harga_satuan',
        'total_harga',
        'tanggal_pembelian',
        'id_supplier',
    ];


    // Relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    // Relasi dengan tabel suppliers
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
