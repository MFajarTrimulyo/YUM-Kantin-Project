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
        Schema::create('detail_pemesanans', function (Blueprint $table) {
            $table->string('id', 20)->primary();

            // FK Pemesanan
            $table->string('fk_order', 20);
            $table->foreign('fk_order')->references('id')->on('pemesanans')->onDelete('cascade');

            // FK Produk
            $table->string('fk_produk', 20);
            $table->foreign('fk_produk')->references('id')->on('produks');

            $table->integer('qty');
            // Simpan harga saat beli
            $table->decimal('harga_satuan_saat_beli', 12, 2); 
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanans');
    }
};
