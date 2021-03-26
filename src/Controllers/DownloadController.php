<?php

namespace FileManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use FileManager\Models\Media;

class DownloadController extends FileManagerController
{
    public function download(Request $request) {
        $media = Media::findOrFail($request->get('file'), ['path', 'name']);
        
        $storage = Storage::disk(config('file-manager.upload_disk'));
        
        return response()->download(
            $storage->path($media->path),
            $media->name
        );
    }
}
