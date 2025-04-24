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
        Schema::create('m_supplier', function (Blueprint $table) {
            $table->increments('supplier_id'); // Primary key, auto increment
            $table->unsignedInteger('kategori_id')->index(); // Foreign key ke m_kategori
            $table->string('kode_supplier')->unique();
            $table->string('nama_supplier');
            $table->text('alamat')->nullable();
           

            $table->timestamps();

            // Relasi ke tabel kategori (misalnya: m_kategori)
            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_supplier');
    }
};

