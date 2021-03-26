<?php

namespace FileManager\Repositories;

use Illuminate\Support\Facades\Auth;
use Lararepo\Repositories\EloquentRepository;

class FolderMediaRepository extends EloquentRepository
{
    /**
     * @var \FileManager\Models\FolderMedia $model
     * */
    protected $model;
    
    public function model()
    {
        return \FileManager\Models\FolderMedia::class;
    }
    
    public function create(array $attributes)
    {
        if (Auth::check()) {
            $attributes['user_id'] = Auth::id();
            $attributes['user_model'] = Auth::user()->getTable();
        }
        
        return parent::create($attributes);
    }
    
    public function update($id, array $attributes)
    {
        if (Auth::check()) {
            $attributes['user_id'] = Auth::id();
            $attributes['user_model'] = Auth::user()->getTable();
        }
        
        return parent::update($id, $attributes);
    }
    
    public function getAllFiles($folder)
    {
        $folder = is_numeric($folder) ? $this->find($folder) :
            $folder;
        
        return $folder->files()->get();
    }
    
    public function getAllChilds($folder) {
        $folder = is_numeric($folder) ? $this->find($folder) :
            $folder;
    
        return $folder->childs()->get();
    }
    
    public function getDirectories($parent_id, $type = 'image') {
        return $this->model->where('parent_id', '=', $parent_id)
            ->where('type', '=', $type)
            ->where('user_id', '=', \Auth::id())
            ->get();
    }
    
    public function checkExists($name, $parent_id = null) {
        return $this->model->where('name', '=', $name)
            ->where('parent_id', '=', $parent_id)
            ->exists();
    }
    
    public function getParent($folder_id) {
        return $this->model->where('id', '=', $folder_id)
            ->first();
    }
}