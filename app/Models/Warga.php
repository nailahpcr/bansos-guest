<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProgramBantuan;


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
        'email', 
        'password', 
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


    /**
     * Relasi untuk program bantuan yang diikuti oleh warga.
     */
    public function programBantuans(): BelongsToMany
    {
        return $this->belongsToMany(ProgramBantuan::class, 'program_bantuan_warga', 'warga_warga_id', 'program_bantuan_program_id')
                    ->withPivot('status', 'tanggal_pengajuan') 
                    ->withTimestamps(); 
    }

}

