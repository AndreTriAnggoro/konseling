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
        Schema::create('dosenwali', function (Blueprint $table) {
            $table->integer('nip_dosenwali')->primary();
            $table->unsignedBigInteger('id_programstudi'); // Kolom foreign key
            $table->string('nama');
            $table->string('email');
            $table->integer('no_hp');
            $table->string('alamat', 100);
            $table->timestamps();

            // Menambahkan foreign key ke tabel programstudi
            $table->foreign('id_programstudi')->references('id_programstudi')->on('programstudi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosenwali');
    }
};
