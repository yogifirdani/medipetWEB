<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_orders',
        'id_product',
        'jumlah_pembelian',
        'harga',
    ];

    public function order()
    {
        return $this->belongsTo(ManageOrder::class, 'id_orders');
    }

    public function product()
    {
        // return $this->belongsTo(Product::class, 'id');
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
