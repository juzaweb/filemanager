<?php

namespace FileManager\Facades;

use FileManager\Contracts\FileManagerContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static FileManager withResource($resource)
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