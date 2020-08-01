<?php

return [
    'load_uthando_configs' => true,
    'php_settings' => [
        'display_startup_errors'        => 0,
        'display_errors'                => 0,
        'error_reporting'               => E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_STRICT & ~E_WARNING & ~E_USER_WARNING,
        'max_execution_time'            => 300,
        'date.timezone'                 => 'Europe/London',
    ],
    'user' => [
        'default_admin_route' => 'admin/shop',
    ],
];
