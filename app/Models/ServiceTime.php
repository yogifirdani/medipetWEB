<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTime extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'service_time'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
