<?php

namespace Tadcms\FileManager\Repositories;

use Illuminate\Support\Facades\Auth;
use Tadcms\Repository\Eloquent\BaseRepository;

class FolderMediaRepository extends BaseRepository
{
    /**
     * @var \Tadcms\FileManager\Models\FolderMedia $model
     * */
    protected $model;
    
    public function model()
    {
        return \Tadcms\FileManager\Models\FolderMedia::class;
    }
    
    public function create(array $attributes)
    {
        if (Auth::check()) {
            $attributes['user_id'] = Auth::id();
            $attributes['user_model'] = get_class(\Auth::user());
        }
        
        return parent::create($attributes);
    }
    
    public function update(array $attributes, $id)
    {
        if (Auth::check()) {
            $attributes['user_id'] = Auth::id();
            $attributes['user_model'] = get_class(\Auth::user());
        }
        
        return parent::update($id, $attributes);
    }

    public function delete($id)
    {
        $mediaRepository = $this->app->make(MediaRepository::class);
        $files = $this->getAllFiles($id);
        foreach ($files as $file) {
            $mediaRepository->delete($file->id);
        }

        return parent::delete($id);
    }
    
    public function getAllFiles($folder)
    {
        $folder = $this->find($folder);
        
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