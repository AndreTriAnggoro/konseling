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
            $table->integer('nim')->primary();
            $table->float('semester1');
            $table->float('semester2');
            $table->float('semester3');
            $table->float('semester4');
            $table->float('semester5');
            $table->float('semester6');
            $table->float('semester7');
            $table->float('semester8');
            $table->float('ipk');
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
