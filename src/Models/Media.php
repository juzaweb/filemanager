<?php

namespace FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'lfm_media';
    protected $fillable = [
        'name',
        'type',
        'mimetype',
        'path',
        'size',
        'extension',
        'folder_id',
        'user_id',
        'user_model',
    ];
    
    public function folder() {
        return $this->belongsTo('FileManager\Models\FolderMedia', 'folder_id', 'id');
    }
}
