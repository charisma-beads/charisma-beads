<?php

declare(strict_types=1);

namespace FileManager\Options;


use FileManager\Controller\FileManagerController;
use Zend\Stdlib\AbstractOptions;

class ElfinderOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $serverOptions = [
        'roots' => [
            [
                'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
                'path'          => APPLICATION_PATH . '/public/userfiles/',                 // path to files (REQUIRED)
                'URL'           => '/userfiles/', // URL to files (REQUIRED)
                'trashHash'     => 't1_Lw',                     // elFinder's hash of trash folder
                'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                'uploadDeny'    => ['all'],                // All Mimetypes not allowed to upload
                'uploadAllow'   => ['image', 'text/plain'],// Mimetype `image` and `text/plain` allowed to upload
                'uploadOrder'   => ['deny', 'allow'],      // allowed Mimetype `image` and `text/plain` only
                'accessControl' => [FileManagerController::class, 'access'],                     // disable and hide dot starting files (OPTIONAL)
            ],
            // Trash volume
            [
                'id'            => '1',
                'driver'        => 'Trash',
                'path'          => APPLICATION_PATH . '/public/userfiles/.trash',
                'tmbURL'        => '/userfiles/.trash/.tmb/',
                'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                'uploadDeny'    => ['all'],                // Recomend the same settings as the original volume that uses the trash
                'uploadAllow'   => ['image', 'text/plain'],// Same as above
                'uploadOrder'   => ['deny', 'allow'],      // Same as above
                'accessControl' => [FileManagerController::class, 'access'],                    // Same as above
            ],
        ],
        'bind'   => [
            // regist action, require
            'upload.presave' => ['Plugin.Watermark.onUpLoadPreSave'],
        ],
        'plugin' => [
            // optional, default values are
            'Watermark' => [
                'enable'         => false,
                'source'         => APPLICATION_PATH . '/public/img/uthando-cms.jpg', // Path to Water mark image
                'marginRight'    => 5,          // Margin right pixel
                'marginBottom'   => 5,          // Margin bottom pixel
                'quality'        => 90,         // JPEG image save quality
                'transparency'   => 70, // Water mark image transparency
                // ( other than PNG )
                'targetMinPixel' => 200         // Target image minimum
                // pixel size
            ],
        ],
    ];

    public function getServerOptions(): array
    {
        return $this->serverOptions;
    }

    public function setServerOptions(array $serverOptions): ElfinderOptions
    {
        $this->serverOptions = $serverOptions;
        return $this;
    }
}
