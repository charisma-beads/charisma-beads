<?php

return [
    'load_uthando_configs' => true,
    'php_settings' => [
        'display_startup_errors'        => false,
        'display_errors'                => true,
        'error_reporting'               => E_ALL ^ E_USER_DEPRECATED,
        'max_execution_time'            => 60,
        'date.timezone'                 => 'Europe/London',
        'zlib.output_compression'       => true,
        'zlib.output_compression_level' => -1,
    ],
    'uthando_user' => [
        'default_admin_route' => 'admin/shop',
    ],
];
