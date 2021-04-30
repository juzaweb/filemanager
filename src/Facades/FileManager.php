<?php

namespace Tadcms\FileManager\Facades;

use Tadcms\FileManager\Contracts\FileManagerContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static FileManager withResource($resource)
 * @method static bool delete(string $path)
 * @method static false|string url(string $path)
 * @method static bool isImage(string $source)
 * @method FileManager setFolder(int $folder_id)
 * @method FileManager setType(string $type)
 * @method FileManager save()
 * */
class FileManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FileManagerContract::class;
    }
}