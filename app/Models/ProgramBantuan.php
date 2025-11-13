<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramBantuan extends Model
{
    use HasFactory;

    /**
     * Nama tabel database yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'program_bantuan';

    /**
     * Primary key yang terkait dengan tabel.
     *
     * @var string
     */
    protected $primaryKey = 'program_id';

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'kode',
        'nama_program',
        'tahun',
        'deskripsi',
        'anggaran',
    ];

    /**
     * Relasi many-to-many ke model Warga.
     * (Untuk fitur "warga mengikuti program")
     */
    public function wargas()
    {
        return $this->belongsToMany(
            Warga::class,
            'program_bantuan_warga',
            'program_bantuan_program_id',
            'warga_warga_id'
        )->withPivot('status', 'tanggal_pengajuan')->withTimestamps();
    }

    public function programBantuans()
{
    return $this->belongsToMany(ProgramBantuan::class, 'program_bantuan_warga', 'warga_id', 'program_bantuan_id');
}
}
