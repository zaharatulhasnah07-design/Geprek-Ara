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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('kode_transaksi')->unique();
        $table->json('items'); // Menampung daftar menu yang dibeli
        $table->integer('total_harga');
        $table->enum('metode_bayar', ['cash', 'qris']);
        $table->integer('uang_bayar')->default(0);
        $table->integer('kembalian')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
