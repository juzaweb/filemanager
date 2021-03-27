<?php

namespace Theanh\FileManager\Providers;

use Theanh\FileManager\Contracts\FileManagerContract;
use Theanh\FileManager\Helpers\FileManager;
use Theanh\FileManager\Repositories\MediaRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class Theanh\FileManager\Providers\FileManagerServiceProvider
 *
 * @package    Theanh\FileManager
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/theanhk/laravel-filemanager
 * @license    MIT
 */
class FileManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootPublishes();
        $this->bootDatabases();
        $this->bootResources();
    }
    
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/file-manager.php', 'file-manager'
        );
    
        $this->app->singleton(FileManagerContract::class, function () {
            return new FileManager($this->app->make(MediaRepository::class));
        });
        
        $this->app->register(UploadServiceProvider::class);
    }
    
    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__.'/../../config/file-manager.php' => config_path('file-manager.php'),
        ], 'config');
        
        $this->publishes([
            __DIR__.'/../../assets' => public_path('vendor/theanh/laravel-filemanager'),
        ], 'assets');
        
        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/theanh/laravel-filemanager'),
        ], 'lang');
    }
    
    protected function bootDatabases()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../migrations');
    }
    
    protected function bootResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'filemanager');
        
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'filemanager');
    }
}