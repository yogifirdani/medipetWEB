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
        Schema::create('restocks', function (Blueprint $table) {
            $table->bigIncrements('id_restock');
            $table->unsignedBigInteger('id_product'); // Foreign key untuk produk
            $table->integer('quantity');
            $table->integer('harga_satuan');
            $table->integer('total_harga');
            $table->date('tanggal_pembelian');
            $table->string('supplier');
            $table->timestamps();

        $table->foreign('id_product')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restocks');
    }
};
