<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'service_type',
        'pet_name',
        'pet_type',
        'price',
        'booking_date',
        'take_date',
        'start_time',
        'total_price',
        'notes',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'service_type', 'id');
    }
}
