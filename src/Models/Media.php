<?php

namespace FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = [
        'name',
        'type',
        'path',
        'size',
        'extension',
        'folder_id',
        'user_id',
    ];
    
    public function folder() {
        return $this->belongsTo('FileManager\Models\FolderMedia', 'folder_id', 'id');
    }
}
