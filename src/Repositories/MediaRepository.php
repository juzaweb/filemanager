<?php

namespace Theanh\FileManager\Repositories;

use Theanh\FileManager\Facades\FileManager;
use Illuminate\Support\Facades\Auth;
use Theanh\Lararepo\Repositories\EloquentRepository;

class MediaRepository extends EloquentRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder $_model;
     * */
    protected $model;
    
    public function model()
    {
        return \Theanh\FileManager\Models\Media::class;
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
    
    public function delete($id)
    {
        FileManager::delete($this->find($id, ['path'])->path);
        
        return parent::delete($id);
    }
    
    public function getFiles($folder_id, $type = 'image', $paginate = null)
    {
        $query = $this->model->where('folder_id', '=', $folder_id);
        
        if ($type) {
            $query->where('type', '=', $type);
        }
        
        if ($paginate) {
            return $query->paginate($paginate);
        }
        
        return $query->get();
    }
}