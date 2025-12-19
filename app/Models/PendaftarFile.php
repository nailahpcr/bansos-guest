<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarFile extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_files';
    protected $primaryKey = 'id';
    protected $fillable = ['pendaftar_id', 'filename', 'path', 'mime_type', 'size'];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id', 'pendaftar_id');
    }

    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}