<?php

namespace Tadcms\FileManager\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tadcms\FileManager\Models\Media;

class DownloadController extends BaseController
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
