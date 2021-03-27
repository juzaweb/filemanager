<?php

namespace FileManager\Controllers;

use Lararepo\Controllers\Controller;

class BaseController extends Controller
{
    protected function getCurrentType() {
        $type = request()->get('type', 'image');
        return strtolower($type);
    }
    
    protected function getCurrentDir() {
        $working_dir = (int) request()->input('working_dir');
        if ($working_dir <= 0) {
            return null;
        }
        
        return $working_dir;
    }
}