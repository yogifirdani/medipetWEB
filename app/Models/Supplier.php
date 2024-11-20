<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = "suppliers";
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'kontak',
        'atm',
        'norek',
    ];

    public function restocks()
    {
        return $this->hasMany(Restock::class, 'id_supplier');
    }
}
