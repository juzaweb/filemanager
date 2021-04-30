- Install package
```
composer require tadcms/filemanager
```

- Publish the package’s config and assets:
```
php artisan vendor:publish --provider="Tadcms\FileManager\Providers\FileManagerServiceProvider" --tag=config
php artisan vendor:publish --provider="Tadcms\FileManager\Providers\FileManagerServiceProvider" --tag=assets
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
    \Tadcms\FileManager\Routes::web();
});
```