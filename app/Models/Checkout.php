<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $table = "checkout";
    protected $primaryKey = "id_co";
    protected $fillable = [
        "id_orders",
        "id_cust",
        "atm",
        "no_rekening",
        "check_in_date"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_cust');
    }

    public function manage_order()
    {
        return $this->belongsTo(ManageOrder::class, 'id_orders');
    }

    public function detailOrder()
    {
        return $this->belongsTo(DetailOrder::class, 'id_orders');
    }
}
