<?php

namespace FileManager\Controllers;

use FileManager\Repositories\FolderMediaRepository;
use FileManager\Repositories\MediaRepository;
use Illuminate\Http\Request;

class ItemsController extends FileManagerController
{
    protected $mediaRepository;
    
    protected $folderRepository;
    
    public function __construct(
        MediaRepository $mediaRepository,
        FolderMediaRepository $folderRepository
    )
    {
        $this->mediaRepository = $mediaRepository;
        $this->folderRepository = $folderRepository;
    }
    
    public function getItems()
    {
        $path = $this->getCurrentDir();
        $type = $this->getCurrentType();

        $files = $this->getFiles($path, $type);
        $previous_dir = $this->getFolderParent($path);
        $directories = $this->getDirectories($path, $type);
        
        return [
            'html' => view('filemanager::grid-view')->with([
                'files' => $files,
                'directories' => $directories,
                'items' => array_merge($directories, $files)
            ])->render(),
            'working_dir' => $path,
            'previous_dir' => $previous_dir
        ];
    }
    
    public function stream($path)
    {
        return response()->file($path);
    }
    
    protected function getDirectories($path, $type = 'image')
    {
        $parent_id = (int) $path > 0 ? $path : null;
        $directories = $this->folderRepository->getDirectories($parent_id, $type);
        
        if ($directories) {
            $result = [];
            
            foreach ($directories as $row) {
                $result[] = (object) [
                    'id' => $row->id,
                    'name' => $row->name,
                    'url' => '',
                    'size' => '',
                    'updated' => strtotime($row->updated_at),
                    'path' => $row->id,
                    'time' => $row->created_at,
                    'type' => 'folder',
                    'icon' => 'fa-folder-o',
                    'thumb' => asset('vendor/tadcms/images/folder.png'),
                    'is_file' => false
                ];
            }
            
            return $result;
        }
        
        return [];
    }
    
    protected function getFiles($folder_id, $type = 'image')
    {
        $files = $this->mediaRepository->getFiles($folder_id, $type);
        $file_icon = $this->getFileIcon();
        
        $result = [];
        
        foreach ($files as $row) {
            $file_url = $this->mediaRepository->getFileUrl($row);
            $thumb = $type == 'image' ? $file_url : null;
            $icon = isset($file_icon[strtolower($row->extension)]) ?
                $file_icon[strtolower($row->extension)] : 'fa-file-o';
            
            $result[] = (object) [
                'id' => $row->id,
                'name' => $row->name,
                'url' => $file_url,
                'size' => $row->size,
                'updated' => strtotime($row->updated_at),
                'path' => $row->path,
                'time' => $row->created_at,
                'type' => $row->mimetype,
                'icon' => $icon,
                'thumb' => $thumb,
                'is_file' => true
            ];
        }
        
        return $result;
    }
    
    protected function getFileIcon()
    {
        return [
            'pdf'  => 'fa-file-pdf-o',
            'doc'  => 'fa-file-word-o',
            'docx' => 'fa-file-word-o',
            'xls'  => 'fa-file-excel-o',
            'xlsx' => 'fa-file-excel-o',
            'rar'  => 'fa-file-archive-o',
            'zip'  => 'fa-file-archive-o',
            'gif'  => 'fa-file-image-o',
            'jpg'  => 'fa-file-image-o',
            'jpeg' => 'fa-file-image-o',
            'png'  => 'fa-file-image-o',
            'ppt'  => 'fa-file-powerpoint-o',
            'pptx' => 'fa-file-powerpoint-o',
            'mp4'  => 'fa-file-video-o',
            'mp3'  => 'fa-file-video-o',
            'jfif' => 'fa-file-image-o',
            'txt'  => 'fa-file-text-o',
        ];
    }
    
    protected function getFolderParent($folder_id) {
        
        $folder = $this->folderRepository->getParent($folder_id);
        
        if ($folder) {
            if (empty($folder->parent_id)) {
                return -1;
            }
            
            return $folder->parent_id;
        }
        
        return '';
    }
}
