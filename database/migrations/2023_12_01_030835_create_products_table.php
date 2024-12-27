<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('jenis_hewan');
            $table->string('kategori');
            $table->string('merek');
            $table->string('berat');
            $table->integer('stok');
            $table->integer('harga');
            $table->string('deskripsi');
            $table->date('kadaluarsa');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
