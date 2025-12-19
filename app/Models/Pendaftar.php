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
        'keterangan',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_id', 'program_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    public function files()
    {
        return $this->hasMany(PendaftarFile::class, 'pendaftar_id', 'pendaftar_id');
    }

    // Hapus method isImage dan pendaftar() yang tidak perlu
}