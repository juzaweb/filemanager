<?php

namespace FileManager\Providers;

use FileManager\Contracts\FileManagerContract;
use FileManager\FileManager;
use FileManager\Repositories\MediaRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class FileManager\Providers\FileManagerServiceProvider
 *
 * @package    Theanh\FileManager
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/theanhk/tadcms
 * @license    MIT
 */
class FileManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
    
    }
    
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/file-manager.php', 'file-manager'
        );
    
        $this->app->singleton(FileManagerContract::class, function () {
            return new FileManager($this->app->make(MediaRepository::class));
        });
        
        $this->registerPublishes();
        
        $this->registerResources();
        
        $this->app->register(UploadServiceProvider::class);
    }
    
    protected function registerPublishes() {
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
    
    protected function registerResources() {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'filemanager');
        
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'filemanager');
    }
}