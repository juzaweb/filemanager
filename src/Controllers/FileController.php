<?php

namespace FileManager\Controllers;

use FileManager\Repositories\MediaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends BaseController
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
            try {
                DB::beginTransaction();
                $this->mediaRepository->delete($id);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }
            
            // event
        }
    
        return 'OK';
    }
    
    public function rename(Request $request)
    {
        $request->validate([
            'new_name' => 'required',
            'id' => 'required|exists:lfm_media,id',
        ], [], [
            'new_name' => trans('filemanager::file-manager.folder-name'),
            'id' => trans('filemanager::file-manager.folder'),
        ]);
        
        try {
            DB::beginTransaction();
            $this->mediaRepository->update($request->post('id'), [
                'name' => $request->post('new_name'),
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        
        return 'OK';
    }
}
