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
        Schema::create('checkout', function (Blueprint $table) {
            $table->bigIncrements('id_co');
            $table->unsignedBigInteger('id_orders');
            $table->unsignedBigInteger('id_cust');
            $table->enum('atm', ['bri', 'bca', 'bni', 'mandiri'])->nullable();
            $table->bigInteger('no_rekening')->nullable();
            $table->date('check_in_date');
            $table->timestamps();

            $table->foreign('id_orders')->references('id_orders')->on('manage_order');
            $table->foreign('id_cust')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout');
    }
};
