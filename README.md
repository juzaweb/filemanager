## About
The file manager intended for using Laravel with CKEditor / TinyMCE. File manager in table database, do not browse on the server folder. Support Laravel 5, 6, 7.

### Features
- [x] DB media and media folder
- [x] Chunk upload support
- [x] CKEditor and TinyMCE integration
- [x] Uploading validation
- [x] Cropping and resizing of images
- [x] Add custom support type
- [x] Image optimize after upload
- [ ] Multi media select

## Install
- Install package
```
composer require theanh/laravel-filemanager
```

- Publish the package’s config and assets:
```
php artisan vendor:publish --provider="Theanh\FileManager\Providers\FileManagerServiceProvider" --tag=config
php artisan vendor:publish --provider="Theanh\FileManager\Providers\FileManagerServiceProvider" --tag=assets
```
- Migration
```
php artisan migrate
```

- Create symbolic link:
```
php artisan storage:link
```

- Edit routes/web.php
```
Route::group(['prefix' => 'file-manager', 'middleware' => ['web', 'auth']], function (){
    \Theanh\FileManager\Routes::web();
});
```

## Configs
```
<?php

return [
    /**
     * Prefix route your file manager
     * Default: file-manager
     * */
    'route_prefix' => env('LFM_PREFIX', 'file-manager'),
    /**
     * File system disk for upload by file-manager
     * Default: public
     * */
    'upload_disk' => env('UPLOAD_DISK', 'public'),

    /**
     * File system disk for temps file
     * Default: local
     * */
    'temp_disk' => env('TEMP_DISK', 'local'),

    /**
     * Optimizer image after upload by file manager
     * You can install the necessary binaries to use
     * Read more: https://github.com/spatie/image-optimizer/blob/master/README.md
     *
     * Default: false
     * */
    'image-optimizer' => true,

    /**
     * File type for file manager: type=filetype
     * You can add new file type
     * Default: image, file
     * */
    'file_types' => [
        'image' => [
            /**
             * Max file size upload for type=image (MB)
             * Default: 15 MB
             * */
            'max_file_size' => 15, //MB
            /**
             * Mime Types file allowed upload for type=image
             * Default: 15 MB
             * */
            'mimetypes' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                // ...
            ]
        ],
        'file' => [
            'max_file_size' => 1024, //MB
            'mimetypes' => [
                'image/jpeg',
                'application/pdf',
                // ...
            ]
        ],
    ]
];
```

## Usage
- Add media with ``\Illuminate\Http\UploadedFile``

```
FileManager::withResource(request()->file('upload_file'))
    ->setFolder($folder_id)
    ->setType($type)
    ->save();
```

- Add media with url
```
FileManager::withResource($urlFile)
    ->setFolder($folder_id)
    ->setType($type)
    ->save();
```

- Add media with path
```
FileManager::withResource($pathFile)
    ->setFolder($folder_id)
    ->setType($type)
    ->save();
```

Note:
```
    $folder_id: Id lfm_folder_media table
    $type: image/file or customs your type
```

- [Editor Integration](https://github.com/theanhk/laravel-filemanager/blob/master/docs/usage-editor.md)
- [Standalone Integration](https://github.com/theanhk/laravel-filemanager/blob/master/docs/usage-editor.md)
- [JavaScript integration](https://github.com/theanhk/laravel-filemanager/blob/master/docs/javascript-integration.md)

## Credits
[Laravel File Manager](https://github.com/UniSharp/laravel-filemanager)

## License

The Laravel File Manager package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
