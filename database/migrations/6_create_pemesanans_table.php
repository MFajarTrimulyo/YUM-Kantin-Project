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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->string('id', 20)->primary();

            // FK User
            $table->string('fk_user', 20);
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');

            // FK Gerai
            $table->string('fk_gerai', 20);
            $table->foreign('fk_gerai')->references('id')->on('gerais')->onDelete('cascade');

            $table->decimal('total_harga', 12, 2);
            $table->enum('status', ['pending', 'cooking', 'ready', 'completed', 'cancelled']);

            $table->string('bukti_bayar')->nullable();
            $table->enum('status_bayar', ['unpaid', 'paid']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
