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
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id('Id_Tindak_Lanjut');
            $table->unsignedBigInteger('Id_Ulasan');
            $table->text('Catatan');
            $table->enum('Status', ['Baru', 'Diproses', 'Selesai'])->default('Baru');
            $table->timestamps();

            $table->foreign('Id_Ulasan')->references('Id_Ulasan')->on('ulasan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut');
    }
};
