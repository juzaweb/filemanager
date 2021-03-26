<?php

namespace FileManager\Controllers;

use Lararepo\Controllers\Controller;

class FileManagerController extends Controller
{
    protected function getCurrentType() {
        $type = request()->get('type', 'image');
        $type = strtolower($type);
        
        switch ($type) {
            case 'image': return 'image';
            case 'images': return 'image';
            case 'file': return 'file';
            case 'files': return 'file';
            default: return 'image';
        }
    }
    
    protected function getCurrentDir() {
        $working_dir = (int) request()->input('working_dir');
        if ($working_dir <= 0) {
            return null;
        }
        
        return $working_dir;
    }
}