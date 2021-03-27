<?php

namespace FileManager\Controllers;

class DeleteController extends BaseController
{
    public function getDelete()
    {
        $name_to_delete = request('items');

        $file_to_delete = parent::getCurrentPath($name_to_delete);
        $thumb_to_delete = parent::getThumbPath($name_to_delete);
        
        if (is_null($name_to_delete)) {
            return parent::error('folder-name');
        }
        
        
        return parent::$success_response;
    }
}
