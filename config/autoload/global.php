<?php

return [
    'load_uthando_configs' => true,
    'php_settings' => [
        'display_startup_errors'        => false,
        'display_errors'                => false,
        'error_reporting'               => E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_STRICT,
        'max_execution_time'            => 300,
        'date.timezone'                 => 'Europe/London',
        //'zlib.output_compression'       => true,
        //'zlib.output_compression_level' => -1,
    ],
    'uthando_user' => [
        'default_admin_route' => 'admin/shop',
    ],
];
