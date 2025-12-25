<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProgramBantuan extends Model
{
    use HasFactory;

    protected $table = 'program_bantuan';
    protected $primaryKey = 'program_id';
    
    protected $fillable = [
        'kode',
        'nama_program',
        'tahun',
        'anggaran',
        'deskripsi',
        'file',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'program_participants', 'program_id', 'user_id');
    }

    public function warga(): BelongsToMany
    {
        return $this->belongsToMany(Warga::class, 'pendaftar_bantuan', 'program_id', 'warga_id')
                    ->withPivot('status');
    }
}