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
        Schema::create('programstudi', function (Blueprint $table) {
            $table->id('id_programstudi');
            $table->unsignedBigInteger('id_jurusan'); // Kolom foreign key
            $table->string('nama_prodi');
            $table->string('nama_kaprodi');
            $table->string('nip_kaprodi');
            $table->integer('no_hp');
            $table->timestamps();

            // Menambahkan foreign key ke tabel jurusan
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programstudi');
    }
};
