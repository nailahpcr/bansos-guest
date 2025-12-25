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


    public function programBantuan(): BelongsToMany
    {
        return $this->belongsToMany(ProgramBantuan::class, 'pendaftar_bantuans', 'warga_id', 'program_id')
                    ->withPivot('status_seleksi');
    }

    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }
}

