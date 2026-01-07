<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatFile extends Model
{
    protected $fillable = [
        'riwayat_id', 
        'filename', 
        'path', 
        'mime_type', 
        'size'
    ];

    public function riwayat()
    {
        return $this->belongsTo(RiwayatPenyaluran::class, 'riwayat_id', 'penyaluran_id');
    }
}