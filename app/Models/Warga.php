<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// UBAH INI: dari Model biasa
// use Illuminate\Database\Eloquent\Model; 
// MENJADI INI: Model yang bisa login
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// TAMBAHKAN INI UNTUK RELASI
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProgramBantuan; // Pastikan Anda sudah punya model ProgramBantuan

// UBAH INI: 'extends Model' MENJADI 'extends Authenticatable'
class Warga extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'warga';
    protected $primaryKey = 'warga_id';

    /**
    * Atribut yang boleh diisi.
    */
    protected $fillable = [
        'no_ktp',
        'nama',
        'email', // <-- Tambahkan
        'password', // <-- Tambahkan
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
    ];

    /**
    * Atribut yang disembunyikan.
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
    * Atribut yang di-casting.
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Otomatis hash saat di-create
    ];

    // =================================================================
    // TAMBAHAN: Relasi Many-to-Many ke Program Bantuan
    // =================================================================
    /**
     * Relasi untuk program bantuan yang diikuti oleh warga.
     */
    public function programBantuans(): BelongsToMany
    {
        // Sesuaikan nama tabel pivot dan foreign key jika berbeda
        return $this->belongsToMany(ProgramBantuan::class, 'program_bantuan_warga', 'warga_warga_id', 'program_bantuan_program_id')
                    ->withPivot('status', 'tanggal_pengajuan') // Ambil juga kolom status & tanggal dari tabel pivot
                    ->withTimestamps(); // Beritahu Laravel bahwa tabel pivot ini juga punya timestamps
    }
    
}

