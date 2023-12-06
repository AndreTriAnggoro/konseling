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
        Schema::create('nilai', function (Blueprint $table) {
            $table->integer('nim')->primary(); // Kolom foreign key
            $table->integer('semester1');
            $table->integer('semester2');
            $table->integer('semester3');
            $table->integer('semester4');
            $table->integer('semester5');
            $table->integer('semester6');
            $table->integer('semester7');
            $table->integer('semester8');
            $table->integer('ipk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
