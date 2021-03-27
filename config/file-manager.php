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
    'image-optimizer' => false,
    
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
                'image/gif',
                'image/svg+xml',
            ]
        ],
        'file' => [
            'max_file_size' => 1024, //MB
            'mimetypes' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
                'application/pdf',
                'text/plain',
                'application/msword',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'video/mp4',
                'audio/mp3',
                'application/octet-stream',
                'application/x-rar-compressed',
                'application/zip',
                'application/x-zip-compressed',
                'multipart/x-zip'
            ]
        ],
    ]
];