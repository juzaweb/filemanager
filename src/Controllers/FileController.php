<?php

namespace FileManager\Controllers;

use Illuminate\Http\Request;
use FileManager\Repositories\MediaRepository;
use Illuminate\Support\Facades\DB;

class FileController extends FileManagerController
{
    protected $mediaRepository;
    
    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }
    
    public function index()
    {
        $type = $this->getCurrentType();
        $mimetypes = config('file-manager.file_types.'. $type .'.mimetypes');
        $max_file_size = config('file-manager.file_types.'. $type .'.max_file_size');

        return view('filemanager::index', [
            'mimetypes' => $mimetypes,
            'max_file_size' => $max_file_size,
        ]);
    }
    
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'is_file' => 'required',
        ], [], [
            'id' => trans('filemanager::file-manager.folder'),
            'is_file' => trans('filemanager::file-manager.is-file'),
        ]);
        
        $id = $request->post('id');
        $is_file = $request->post('is_file');
        
        if ($is_file){
            
            $this->mediaRepository->delete($id);
            
            // event
            
        }
    
        return response([
            'status' => true,
            'data' => [
                'message' => trans('filemanager::file-manager.successfully')
            ],
        ]);
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
            $this->mediaRepository->update($request->post('id'), [
                'name' => $request->post('new_name'),
            ]);
        });
        
        return response([
            'status' => true,
            'data' => [
                'message' => trans('filemanager::file-manager.successfully')
            ],
        ]);
    }
    
    public function getErrors()
    {
        $arr_errors = [];
        
        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            array_push($arr_errors, trans('file-manager.message-extension_not_found'));
        }
        
        return $arr_errors;
    }
}
