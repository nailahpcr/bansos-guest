<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    protected $primaryKey = 'warga_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];

    public $timestamps = true;

    public function programBantuan()
    {
        return $this->belongsToMany(ProgramBantuan::class, 'penerima_manfaat', 'warga_id', 'program_id');
    }
}


