<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiwayatPenyaluran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penyaluran_bantuans';
    protected $primaryKey = 'penyaluran_id';

    protected $fillable = [
        'program_id',
        'penerima_id',
        'tahap_ke',
        'tanggal',
        'nilai',
        'file',
        'foto_penyerahan', // Tambahkan ini sesuai gambar database Anda
    ];

    public function program()
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_id', 'program_id');
    }

    public function penerima()
    {
        return $this->belongsTo(PenerimaBantuan::class, 'penerima_id', 'penerima_id');
    }
    
    public function files()
    {
        return $this->hasMany(RiwayatFile::class, 'riwayat_id');
    }
}