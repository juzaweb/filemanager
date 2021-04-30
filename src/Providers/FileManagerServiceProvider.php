<?php

namespace Tadcms\FileManager\Providers;

use Tadcms\FileManager\Contracts\FileManagerContract;
use Tadcms\FileManager\Helpers\FileManager;
use Tadcms\FileManager\Repositories\MediaRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class Tadcms\FileManager\Providers\FileManagerServiceProvider
 *
 * @package    Tadcms\FileManager
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/filemanager
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
            __DIR__ . '/../../config/file-manager.php',
            'file-manager'
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
            __DIR__.'/../../assets' => public_path('tadcms/filemanager'),
        ], 'assets');
        
        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/tadcms/filemanager'),
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