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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('nama_peminjam');
            $table->integer('total_buku');
            $table->integer('total_bayar');
            $table->integer('lama_pinjam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('total_buku');
            $table->integer('total_bayar');
            $table->integer('lama_pinjam');
        });
    }
};
