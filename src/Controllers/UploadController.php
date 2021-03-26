<?php

namespace FileManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use FileManager\Exceptions\UploadMissingFileException;
use FileManager\Handler\HandlerFactory;
use FileManager\Receiver\FileReceiver;
use FileManager\Services\FileUploadService;

class UploadController extends FileManagerController
{
    protected $errors = [];
    
    public function upload(Request $request)
    {
        $error_bag = [];
    
        //try {
        
            $receiver = new FileReceiver('upload', $request, HandlerFactory::classFromRequest($request));
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
        
            $save = $receiver->receive();
            if ($save->isFinished()) {
                
                $new_file = $this->saveFile($save->getFile());
                if ($new_file) {
                    
                    // event
                    
                    return $this->success('Upload success.');
                }
                
                return $this->error('');
            }
        
            $handler = $save->handler();
        
            return response()->json([
                "done" => $handler->getPercentageDone(),
                'status' => true
            ]);
        
        /*} catch (\Exception $e) {
            \Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        
            array_push($error_bag, $e->getMessage());
            return $this->response($error_bag);
        }*/
    }
    
    protected function saveFile(UploadedFile $file) {
        $folder_id = request()->input('working_dir');
        $type = $this->getCurrentType();
        
        return (new FileUploadService())
            ->withResource($file)
            ->setFolder($folder_id)
            ->setType($type)
            ->save();
    }
    
    protected function useFile($new_filename)
    {
        $file = parent::getFileUrl($new_filename);

        $responseType = request()->input('responseType');
        if ($responseType && $responseType == 'json') {
            return [
                "uploaded" => 1,
                "fileName" => $new_filename,
                "url" => $file,
            ];
        }

        return "<script type='text/javascript'>

        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);
            return ( match && match.length > 1 ) ? match[1] : null;
        }

        var funcNum = getUrlParam('CKEditorFuncNum');

        var par = window.parent,
            op = window.opener,
            o = (par && par.CKEDITOR) ? par : ((op && op.CKEDITOR) ? op : false);

        if (op) window.close();
        if (o !== false) o.CKEDITOR.tools.callFunction(funcNum, '$file');
        </script>";
    }
    
    protected function pathinfo($path, $options = null)
    {
        $path = urlencode($path);
        $parts = is_null($options) ? pathinfo($path) : pathinfo($path, $options);
        if (is_array($parts)) {
            foreach ($parts as $field => $value) {
                $parts[$field] = urldecode($value);
            }
        } else {
            $parts = urldecode($parts);
        }

        return $parts;
    }
}
