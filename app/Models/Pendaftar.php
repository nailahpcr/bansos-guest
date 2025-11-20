<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_bantuan';
    protected $primaryKey = 'pendaftar_id';
    
    protected $fillable = [
        'program_id',
        'warga_id',
        'tanggal_daftar',
        'status',
        'keterangan'
    ];

    // Relasi: Satu pendaftaran dimiliki oleh satu program
    public function program()
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_id', 'program_id');
    }

    // Relasi: Satu pendaftaran dimiliki oleh satu warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }
}
