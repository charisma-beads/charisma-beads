<?php

use FileManager\Controller\FileManagerController;
use FileManager\Controller\SettingsController;
use FileManager\Controller\UploaderController;
use FileManager\Options\ElfinderOptions;
use FileManager\Options\FileManagerOptions;
use FileManager\Options\Factory\ElfinderOptionsFactory;
use FileManager\Options\Factory\FileManagerOptionsFactory;
use FileManager\Service\ImageUploader;
use FileManager\Service\Uploader;
use FileManager\Validator\IsImage;
use FileManager\Validator\MimeType;
use FileManager\View\FileManager;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'js/legacy-upload.js' => [
                    'js/jquery.ui.widget.js',
                    'js/jquery.iframe-transport.js',
                    'js/jquery.fileupload.js',
                ],
                'js/summernote.js' => [
                    'js/summernote-elfinder.js',
                ],
            ],
            'aliases' => [
                'el-finder/js/'             => './vendor/studio-42/elfinder/js/',
                'el-finder/css/'            => './vendor/studio-42/elfinder/css/',
                'el-finder/img/'            => './vendor/studio-42/elfinder/img/',
                'el-finder/sounds/'         => './vendor/studio-42/elfinder/sounds/',
            ],
            'paths' => [
                'FileManager' => __DIR__ . '/../public',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            FileManagerController::class    => FileManagerController::class,
            SettingsController::class       => SettingsController::class,
            UploaderController::class       => UploaderController::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            ElfinderOptions::class      => ElfinderOptionsFactory::class,
            FileManagerOptions::class   => FileManagerOptionsFactory::class,
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            ImageUploader::class    => ImageUploader::class,
            Uploader::class         => Uploader::class,
        ]
    ],
    'validators' => [
        'aliases' => [
            'fileisimage'   => IsImage::class,
            'filemimetype'  => MimeType::class,
        ],
        'invokables' => [
            IsImage::class => IsImage::class,
            MimeType::class => MimeType::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'fileManager' => FileManager::class,
        ],
        'invokables' => [
            FileManager::class => FileManager::class,
        ]
    ],
    'view_manager'  => [
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
];
