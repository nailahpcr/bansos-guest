<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaModel extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $primaryKey = 'media_id';
    
    protected $fillable = [
        'ref_table',    
        'ref_id',       
        'file_name',   
        'caption',      
        'mime_type',   
        'sort_order',   
    ];
    
    public $timestamps = true;
    
    /**
     * Relasi polymorphic.
     */
    public function mediable()
    {
        return $this->morphTo(null, 'ref_table', 'ref_id');
    }
}