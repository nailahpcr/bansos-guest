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
    // BERITAHU MODEL UNTUK MENGGUNAKAN TABEL 'program_bantuan' (singular)
    protected $table = 'program_bantuan';

    /**
     * Primary key yang terkait dengan tabel.
     *
     * @var string
     */
    // BERITAHU MODEL APA PRIMARY KEY-NYA
    protected $primaryKey = 'program_id';

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array
     */
    // SESUAIKAN DENGAN KOLOM DI DATABASE ANDA
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
            'program_bantuan_warga', // Nama tabel pivot
            'program_bantuan_program_id', // Foreign key di pivot
            'warga_warga_id' // Foreign key lain di pivot
        )->withPivot('status', 'tanggal_pengajuan')->withTimestamps();
    }

    public function programBantuans()
{
    // return $this->belongsToMany(RelatedModel, 'pivot_table_name', 'foreign_pivot_key', 'related_pivot_key');
    return $this->belongsToMany(ProgramBantuan::class, 'program_bantuan_warga', 'warga_id', 'program_bantuan_id');
}
}
