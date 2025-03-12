<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->unsignedBigInteger('user_id')->index(); // Foreign key ke m_user
            $table->date('tanggal');
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();

            // Foreign key ke tabel m_user
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_penjualan');
    }
};
