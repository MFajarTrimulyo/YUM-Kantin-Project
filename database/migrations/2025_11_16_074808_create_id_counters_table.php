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
        Schema::create('id_counters', function (Blueprint $table) {
            $table->id(); // ID internal counter (biarkan auto increment)
            
            $table->string('table_name');
            $table->string('year_suffix', 2);
            $table->integer('last_number');

            $table->unique(['table_name', 'year_suffix']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_counters');
    }
};
