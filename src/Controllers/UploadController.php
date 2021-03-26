<?php

namespace FileManager\Controllers;

use FileManager\FileManager;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use FileManager\Exceptions\UploadMissingFileException;
use FileManager\Handler\HandlerFactory;
use FileManager\Receiver\FileReceiver;

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
            
            $new_file = $this->saveFile($save->getFile());
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
        
        return (new FileManager())
            ->setResource($file)
            ->setFolder($folder_id)
            ->setType($type)
            ->save();
    }
}