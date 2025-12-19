<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenyaluran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penyalurans';
    protected $primaryKey = 'penyaluran_id';
    
    protected $fillable = [
        'program_id',
        'penerima_id',
        'tahap_ke',
        'tanggal_penyaluran',
        'nilai_bantuan',
        'bukti_penyaluran',
    ];

    // Relasi ke Program
    public function program()
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_id', 'program_id');
    }

    // Relasi ke Penerima (Pendaftar)
    public function penerima()
    {
        // Sesuaikan nama model Pendaftar/Warga Anda
        return $this->belongsTo(Pendaftar::class, 'penerima_id', 'pendaftar_id');
    }
}
