<?php

Route::group([
    'namespace' => '\FileManager\Controllers'
], function () {
    Route::get('/', 'FileController@index')->name('file-manager.index');
    
    Route::get('/get-items', 'ItemsController@getItems')->name('file-manager.get-items');
    
    Route::post('/upload', 'UploadController@upload')->name('file-manager.upload');
    
    Route::get('/errors', 'FileController@getErrors')->name('file-manager.errors');
    
    Route::get('/download', 'DownloadController@download')->name('file-manager.download');
    
    Route::group(['prefix' => 'folder'], function () {
        Route::post('/add-folder', 'FolderController@create')->name('file-manager.folder.new');
        
        Route::post('/rename', 'FolderController@rename')->name('file-manager.folder.rename');
        
        Route::post('/delete', 'FolderController@delete')->name('file-manager.folder.delete');
    });
    
    Route::group(['prefix' => 'file'], function () {
        Route::post('/rename', 'FileController@rename')->name('file-manager.file.delete');
        
        Route::post('/delete', 'FileController@delete')->name('file-manager.file.delete');
    });
});