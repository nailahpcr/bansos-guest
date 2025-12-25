<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftarFile extends Model
{
    protected $table = 'pendaftar_files';
    protected $fillable = ['pendaftar_id', 'filename', 'path', 'mime_type', 'size'];
}

