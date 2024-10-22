<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ManageOrder extends Model
{
    use HasFactory;

    protected $table = 'manage_order';
    protected $primaryKey = 'id_orders';
    protected $fillable = [
        'id_cust',
        'id_product',
        'jumlah_pembelian',
        'total_harga',
        // 'atm',
        // 'no_rekening',
        'status_pesanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_cust');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function co()
    {
        return $this->HasOne(Checkout::class, 'id_orders', 'id_orders');
    }
}
