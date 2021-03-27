## About
Media gallery with CKEditor, TinyMCE and Summernote support. Built on Laravel file system.

### Features
- [x] DB media and media folder
- [x] Chunk upload support
- [x] CKEditor and TinyMCE integration
- [x] Uploading validation
- [x] Cropping and resizing of images
- [x] Add custom support type
- [ ] Multi media select

## Install
- Install package
```
composer require theanh/laravel-filemanager
```

- Publish the package’s config and assets:
```
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=assets
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

## Usage
### Basic

### Events

## License

The Laravel File Manager package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
