<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftarBantuan extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_bantuans';    
    protected $primaryKey = 'pendaftar_id';
    
    protected $fillable = [
        'program_id',
        'warga_id',
        'tanggal_daftar',
        'status_seleksi',
        'keterangan',
        'file',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }


   public function verifikasiLapangan()
    {
        return $this->hasOne(VerifikasiLapangan::class, 'pendaftar_id');
    }

    // app/Models/PendaftarBantuan.php

    public function files()
    {
        // Ini menghubungkan pendaftar ke banyak file
        return $this->hasMany(PendaftarFile::class, 'pendaftar_id', 'pendaftar_id');
    }

    public function user()
{
    // Pastikan foreign key di tabel pendaftar_bantuans adalah user_id
    return $this->belongsTo(User::class, 'user_id', 'id');
}

}


