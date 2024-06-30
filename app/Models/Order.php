<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'service_type',
        'pet_type',
        'start_date',
        'end_date',
        'start_time',
        'total_price',
        'total',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'service_type', 'id');
    }
}
