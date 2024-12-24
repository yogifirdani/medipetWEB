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
        Schema::create('manage_order', function (Blueprint $table) {
            $table->bigIncrements('id_orders');
            $table->unsignedBigInteger('id_cust')->nullable();
            $table->string('nama')->nullable();
            $table->string('telepon')->nullable();
            $table->enum('status_pesanan', ['ditolak', 'proses', 'lunas'])->default('proses');
            $table->timestamps();

            $table->foreign('id_cust')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_order');
    }
};
