<?php

namespace FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class FolderMedia extends Model
{
    protected $table = 'lfm_folder_media';
    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'user_id',
        'user_model',
    ];
    
    public function parent() {
        return $this->belongsTo('FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function childs()
    {
        return $this->hasMany('FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function files()
    {
        return $this->hasMany('FileManager\Models\Media', 'folder_id', 'id');
    }
}
