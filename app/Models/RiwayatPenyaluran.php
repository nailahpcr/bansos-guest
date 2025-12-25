<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenyaluran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penyaluran_bantuans';
    protected $primaryKey = 'penyaluran_id';
    
    protected $fillable = [
        'program_id',
        'penerima_id',
        'tahap_ke',
        'tanggal_penyaluran',
        'tanggal',
        'nilai',
        'file',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_id', 'program_id');
    }

    public function penerima()
    {
        return $this->belongsTo(PenerimaBantuan::class, 'penerima_id', 'penerima_id');
    }
    public function pendaftar()
{
    // Pastikan pendaftar_id adalah foreign key di tabel riwayat_penyalurans
    return $this->belongsTo(PendaftarBantuan::class, 'pendaftar_id');
}
}