<?php

namespace FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class FolderMedia extends Model
{
    protected $table = 'folder_media';
    protected $fillable = [
        'name',
        'user_id',
        'type',
        'parent_id',
    ];
    
    public function parent() {
        return $this->belongsTo('FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function childs()
    {
        return $this->hasMany('FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function files() {
        return $this->hasMany('FileManager\Models\Media', 'folder_id', 'id');
    }
}
