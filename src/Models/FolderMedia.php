<?php

namespace Tadcms\FileManager\Models;

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
    
    public function parent()
    {
        return $this->belongsTo('Tadcms\FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function childs()
    {
        return $this->hasMany('Tadcms\FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function files()
    {
        return $this->hasMany('Tadcms\FileManager\Models\Media', 'folder_id', 'id');
    }
}
