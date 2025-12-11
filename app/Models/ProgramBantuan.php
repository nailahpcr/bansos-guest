<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramBantuan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * @var string
     */
    protected $table = 'program_bantuan';

    /**
     * Kunci utama tabel.
     * @var string
     */
    protected $primaryKey = 'program_id';
    
    /**
     * Kolom yang dapat diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'nama_program',
        'tahun',
        'anggaran',
        'deskripsi',
    ];
    
    /**
     * Relasi ke tabel media.
     */
    public function media()
    {
        return $this->morphMany(MediaModel::class, null, 'ref_table', 'ref_id');
    }
    
    /**
     * Relasi ke users (many-to-many).
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'program_participants', 'program_id', 'user_id');
    }
}