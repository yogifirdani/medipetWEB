<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('kategori'); // Category of the expense
            $table->string('nama_produk'); // Name of the product
            $table->integer('jumlah'); // Quantity of the product
            $table->decimal('total', 10, 2); // Total amount
            $table->date('tanggal'); // Date of the transaction
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluarans');
    }
}
