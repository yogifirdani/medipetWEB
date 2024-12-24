<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_category',
        'service_category',
        'take_status',
        'price'
    ];

    protected $casts = [
        'service_time' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_type');
    }

    public function serviceTimes()
    {
        return $this->hasMany(ServiceTime::class);
    }

    public static function jmlLayanan()
    {
        return self::count();
    }
}
