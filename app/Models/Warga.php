<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProgramBantuan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


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
        'password' => 'hashed', 
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

    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        // Iterasi melalui setiap kolom yang diizinkan untuk difilter
        foreach ($filterableColumns as $column) {
            // Cek apakah request memiliki nilai untuk kolom saat ini
            if ($request->filled($column)) {
                // Tambahkan kondisi WHERE ke query
                $query->where($column, $request->input($column));
            }
        }
        
        return $query;
    }
}

