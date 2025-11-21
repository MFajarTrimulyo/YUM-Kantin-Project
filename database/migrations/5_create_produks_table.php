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
        Schema::create('produks', function (Blueprint $table) {
            $table->string('id', 20)->primary();
    
            // FK Gerai
            $table->string('fk_gerai', 20);
            $table->foreign('fk_gerai')->references('id')->on('gerais')->onDelete('cascade');
            
            // FK Kategori
            $table->foreignId('fk_kategori')->constrained('kategoris')->onDelete('cascade');
            
            $table->string('photo')->nullable();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('pilihan_rasa')->nullable();
            $table->decimal('harga', 12, 2);
            $table->decimal('harga_diskon', 12, 2);
            $table->integer('stok')->default(0);
            $table->integer('terjual')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
