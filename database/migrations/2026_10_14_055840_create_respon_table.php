<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respon', function (Blueprint $table) {
            $table->id(); // Primary Key standar untuk tabel respon (kolom 'id')
            $table->unsignedBigInteger('Id_Respon'); // Kolom untuk menyimpan ID ulasan yang dibalas
            $table->text('Respon'); // Isi balasan
            $table->timestamps();

            // Menghubungkan Id_Respon ke tabel ulasan (kolom Id_Ulasan)
            $table->foreign('Id_Respon')->references('Id_Ulasan')->on('ulasan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respon');
    }
};