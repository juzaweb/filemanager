<?php

namespace FileManager\Controllers;

use FileManager\Repositories\FolderMediaRepository;
use Illuminate\Http\Request;

class FolderController extends FileManagerController
{
    protected $folderRepository;
    
    public function __construct(
        FolderMediaRepository $folderRepository
    )
    {
        $this->folderRepository = $folderRepository;
    }
    
    public function getFolders()
    {
        $root_folders = [];
        $type = $this->getCurrentType();
        $folders = $this->folderRepository->getDirectories(0, $type);

        $root_folders[] = (object) [
            'name' => trans('tadcms::file-manager.root-folders'),
            'path' => 0,
            'children' => $folders,
            'has_next' => false,
        ];

        return view('tadcms::backend.file-manager.tree', [
            'root_folders' => $root_folders
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'parent_id' => 'nullable|exists:folder_media,id',
        ], [], [
            'name' => trans('tadcms::file-manager.folder-name'),
            'parent_id' => trans('tadcms::file-manager.parent'),
        ]);
    
        $name = $request->post('name');
        $parent_id = $request->post('parent_id');
        
        if ($this->folderRepository->checkFolderExists($name, $parent_id)) {
            return $this->error('tadcms::file-manager.folder-exists');
        }
    
        $folder = $this->folderRepository->create(
            $request->all()
        );
        
        do_action('file-manager.add-folder-success', $folder);
        
        return parent::$success_response;
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'required',
            'is_file' => 'required',
        ], [], [
            'id' => trans('tadcms::file-manager.folder'),
            'is_file' => trans('tadcms::file-manager.is-file'),
        ]);
        
        $id = $request->post('id');
        $is_file = $request->post('is_file');
        
        if (!$is_file){
    
            $this->folderRepository->delete($id);
    
            do_action('file-manager.delete-folder-success', $id);
        }

        return $this->success('tadcms::file-manager.successfully');
    }
    
    public function rename(Request $request)
    {
        $request->validate([
            'new_name' => 'required',
            'id' => 'required|exists:folder_media,id',
        ], [], [
            'new_name' => trans('tadcms::file-manager.folder-name'),
            'id' => trans('tadcms::file-manager.folder'),
        ]);
        
        $this->folderRepository->update($request->post('id'), [
            'name' => $request->post('new_name'),
        ]);
        
        return $this->success('tadcms::file-manager.successfully');
    }
}
