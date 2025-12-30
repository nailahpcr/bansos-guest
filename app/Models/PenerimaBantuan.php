<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerimaBantuan extends Model
{
    protected $table = 'penerima_bantuans';
protected $primaryKey = 'penerima_id'; // Sesuai image_a0718a

    protected $fillable = [
        'program_id',
        'warga_id',
        'keterangan',
    ];

    public function warga() 
{
    // Menghubungkan warga_id di tabel penerima ke warga_id di tabel wargas
    return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
}

public function program() 
{
    return $this->belongsTo(ProgramBantuan::class, 'program_id', 'program_id');
}
    

    public function pendaftar() {
    return $this->belongsTo(PendaftarBantuan::class, 'pendaftar_id');
}

    public function riwayatPenyaluran()
    {
        return $this->hasMany(RiwayatPenyaluran::class, 'penerima_id');
    }
}
