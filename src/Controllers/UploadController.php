<?php

namespace FileManager\Controllers;

use FileManager\Facades\FileManager;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use FileManager\Exceptions\UploadMissingFileException;
use FileManager\Handler\HandlerFactory;
use FileManager\Receiver\FileReceiver;
use Illuminate\Support\Facades\DB;

class UploadController extends FileManagerController
{
    protected $errors = [];
    
    public function upload(Request $request)
    {
        $receiver = new FileReceiver(
            'upload',
            $request,
            HandlerFactory::classFromRequest($request)
        );
        
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
    
        $save = $receiver->receive();
        if ($save->isFinished()) {
            try {
                DB::beginTransaction();
                $new_file = $this->saveFile($save->getFile());
                DB::commit();
            }
            catch (\Exception $exception) {
                DB::rollBack();
                unlink($save->getFile()->getRealPath());
                throw $exception;
            }
            
            if ($new_file) {
                
                // event
                
                return response()->json([
                    'status' => true,
                    'data' => [
                        'message' => 'Upload success.'
                    ]
                ]);
            }
            
            return response()->json([
                'status' => false,
                'errors' => [
                    'message' => 'Can\'t save your file.'
                ]
            ]);
        }
    
        $handler = $save->handler();
    
        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }
    
    protected function saveFile(UploadedFile $file)
    {
        $folder_id = $this->getCurrentDir();
        $type = $this->getCurrentType();
        
        return FileManager::withResource($file)
            ->setFolder($folder_id)
            ->setType($type)
            ->save();
    }
}
