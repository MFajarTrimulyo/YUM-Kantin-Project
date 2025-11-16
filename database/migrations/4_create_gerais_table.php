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
        Schema::create('gerais', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            
            // FK Users
            $table->string('fk_user', 20);
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');

            // FK Kantin
            $table->string('fk_kantin', 20);
            $table->foreign('fk_kantin')->references('id')->on('kantins')->onDelete('cascade');

            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerais');
    }
};
