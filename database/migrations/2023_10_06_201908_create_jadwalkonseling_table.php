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
        Schema::create('jadwalkonseling', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->integer('nim');
            $table->integer('nip_dosenwali');
            $table->unsignedBigInteger('id_topik');
            $table->datetime('tanggal');
            $table->string('status_verifikasi')->default('dikirim');
            $table->enum('metode_konsultasi', ['online', 'offline']);
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->foreign('nip_dosenwali')->references('nip_dosenwali')->on('dosenwali');
            $table->foreign('id_topik')->references('id_topik')->on('topikkonseling');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwalkonseling');
    }
};
