<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tindaklanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut';
    protected $primaryKey = 'Id_Tindak_Lanjut';

    protected $fillable = [
        'Id_Ulasan',
        'Catatan',
        'Status',
    ];

    public function ulasan()
    {
        return $table = $this->belongsTo(ulasan::class, 'Id_Ulasan', 'Id_Ulasan');
    }
}