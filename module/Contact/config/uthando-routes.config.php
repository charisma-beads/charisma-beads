<?php

use Contact\Controller\SettingsController;

return [
    'router' => [
        'routes' => [
            'admin' => [
        		'child_routes' => [
        			'contact' => [
        				'type'    => 'Segment',
        				'options' => [
        					'route'    => '/contact',
        					'defaults' => [
        						'__NAMESPACE__' => 'Contact\Controller',
        						'controller'    => SettingsController::class,
        						'action'        => 'index',
        					],
        				],
        				'may_terminate' => true,
        			],
        		],
        	],
        ],
    ],
];
