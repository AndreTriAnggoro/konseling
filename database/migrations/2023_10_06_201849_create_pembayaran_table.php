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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->integer('nim'); // Kolom foreign key
            $table->integer('jumlah_pembayaran');
            $table->enum('status_pembayaran', ['Belum Bayar', 'Dalam Proses', 'Lunas']);
            $table->date('tanggal_pembayaran');
            $table->string('bukti_pembayaran');
            $table->timestamps();

            // Menambahkan foreign key ke tabel mahasiswa
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
