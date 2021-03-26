<?php

namespace FileManager\Controllers;

use FileManager\Repositories\FolderMediaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FolderController extends FileManagerController
{
    protected $folderRepository;
    
    public function __construct
    (
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
            'name' => trans('filemanager::file-manager.root-folders'),
            'path' => 0,
            'children' => $folders,
            'has_next' => false,
        ];

        return view('filemanager::backend.file-manager.tree', [
            'root_folders' => $root_folders
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'parent_id' => 'nullable|exists:folder_media,id',
        ], [], [
            'name' => trans('filemanager::file-manager.folder-name'),
            'parent_id' => trans('filemanager::file-manager.parent'),
        ]);
    
        $name = $request->post('name');
        $parentId = $request->post('parent_id');
        
        if ($this->folderRepository->exists(['name' => $name, 'parent_id' => $parentId])) {
            return $this->error('filemanager::file-manager.folder-exists');
        }
    
        DB::transaction(function () use ($request) {
            $folder = $this->folderRepository->create(
                $request->all()
            );
        });
        
        // event
        
        return parent::$success_response;
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'required',
            'is_file' => 'required',
        ], [], [
            'id' => trans('filemanager::file-manager.folder'),
            'is_file' => trans('filemanager::file-manager.is-file'),
        ]);
        
        $id = $request->post('id');
        $isFile = $request->post('is_file');
        
        if (!$isFile){
            DB::transaction(function () use ($id) {
                $this->folderRepository->delete($id);
            });
        }

        return $this->success('filemanager::file-manager.successfully');
    }
    
    public function rename(Request $request)
    {
        $request->validate([
            'new_name' => 'required',
            'id' => 'required|exists:folder_media,id',
        ], [], [
            'new_name' => trans('filemanager::file-manager.folder-name'),
            'id' => trans('filemanager::file-manager.folder'),
        ]);
    
        DB::transaction(function () use ($request) {
            $this->folderRepository->update($request->post('id'), [
                'name' => $request->post('new_name'),
            ]);
        });
        
        return $this->success('filemanager::file-manager.successfully');
    }
}
