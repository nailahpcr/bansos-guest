<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramBantuan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     * Diubah sesuai dengan nama tabel Anda.
     * @var string
     */
    protected $table = 'program_bantuan'; // <- UBAH DI SINI

    /**
     * Primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'program_id';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'nama_program',
        'tahun',
        'deskripsi',
        'anggaran',
    ];

    /**
     * Tipe data asli dari atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun' => 'integer',
        'anggaran' => 'float',
    ];
}

