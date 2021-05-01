<?php

namespace Tadcms\FileManager\Repositories;

use Tadcms\FileManager\Facades\FileManager;
use Illuminate\Support\Facades\Auth;
use Tadcms\Repository\Eloquent\BaseRepository;

class MediaRepository extends BaseRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder $_model;
     * */
    protected $model;
    
    public function model()
    {
        return \Tadcms\FileManager\Models\Media::class;
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