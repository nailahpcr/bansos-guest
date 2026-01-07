<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pendaftar;

class VerifikasiLapangan extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_lapangans';
    protected $primaryKey = 'verifikasi_id';
    protected $fillable = [
        'pendaftar_id',
        'petugas',
        'tanggal',
        'catatan',
        'skor',
        'file',
    ];

    protected $casts = [
        'file' => 'array',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(PendaftarBantuan::class, 'pendaftar_id','pendaftar_id');
    }

    public function files()
    {
        return $this->hasMany(VerifikasiFile::class, 'verifikasi_id', 'verifikasi_id');
    }
}
