<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerimaBantuan extends Model
{
    use HasFactory;

    protected $table = 'penerima_bantuan';
    protected $primaryKey = 'penerima_id'; 
    protected $guarded = [];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id'); 
    }

    public function program()
    {
        return $this->belongsTo(ProgramBantuan::class, 'program_id', 'program_id'); 
    }
}
