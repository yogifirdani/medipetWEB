<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description',
        'category_id',
        'income',
        'expense',
        'balance',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
