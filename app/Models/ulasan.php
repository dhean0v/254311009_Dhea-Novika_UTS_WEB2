<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'Id_Ulasan';

    protected $fillable = [
        'Id_Penjual',
        'Nama_Pembeli',
        'Ulasan',
        'Rating',
    ];

    // Relasi ke tabel penjual
    public function penjual()
    {
        return $this->belongsTo(penjual::class, 'Id_Penjual', 'Id_Penjual');
    }

    // --- TAMBAHKAN FUNGSI INI AGAR BISA TERHUBUNG KE TABEL RESPON ---
    public function respon()
    {
        return $this->hasOne(Respon::class, 'Id_Respon', 'Id_Ulasan');
    }
}