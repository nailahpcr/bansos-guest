<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiFile extends Model
{
    protected $table = 'verifikasi_files';
    protected $fillable = ['verifikasi_id', 'filename', 'path', 'mime_type', 'size'];
}
