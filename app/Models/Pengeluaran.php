<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    // Define the fillable attributes
    protected $fillable = [
        'kategori', // Add kategori here
        'nama_produk',
        'jumlah',
        'total',
        'tanggal',
    ];

    // Other model methods and properties...
}
