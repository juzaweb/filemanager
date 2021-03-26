<?php

namespace FileManager\Controllers;

use Illuminate\Support\Facades\File;

class RenameController extends FileManagerController
{
    public function getRename()
    {
        $old_name = parent::translateFromUtf8(request('file'));
        $new_name = parent::translateFromUtf8(trim(request('new_name')));

        $old_file = parent::getCurrentPath($old_name);
        if (File::isDirectory($old_file)) {
            return $this->renameDirectory($old_name, $new_name);
        } else {
            return $this->renameFile($old_name, $new_name);
        }
    }

    protected function renameDirectory($old_name, $new_name)
    {
        if (empty($new_name)) {
            return $this->error('folder-name');
        }

        $old_file = parent::getCurrentPath($old_name);
        $new_file = parent::getCurrentPath($new_name);

        
        
        return parent::$success_response;
    }

    protected function renameFile($old_name, $new_name)
    {
        if (empty($new_name)) {
            return parent::error('file-name');
        }

        $old_file = parent::getCurrentPath($old_name);
        $extension = File::extension($old_file);
        $new_file = parent::getCurrentPath(basename($new_name, ".$extension") . ".$extension");
        
        return parent::$success_response;
    }
}
