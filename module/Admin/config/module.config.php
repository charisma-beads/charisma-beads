<?php

return array(
	'admin_options' => array(
		'default_route' => 'admin/application',
	),
	'router' => array(
		'routes' => array(
			'admin' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/admin',
					'defaults' => array(
						'__NAMESPACE__' => 'Admin\Controller',
						'controller'    => 'Admin',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
			),
		),
	),
	'admin' => array(
		'admin_layout_template' => 'layout/admin',
	),
	'navigation' => array(
		'admin' => array(
			'home' => array(
				'label' => 'Home',
				'route' => 'home',
				'resource' => 'menu:admin',
			),
		),
	),
	'view_manager' => array(
	   'template_path_stack' => array(
			__DIR__ . '/../view',
		),
    ),
);