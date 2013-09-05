<?php
return array(
	'router' => array(
		'routes' => array(
        	'application' => array(
            	'child_routes' => array(
					'article' => array(
						'type'    => 'Segment',
                        'options' => array(
                            'route'         => '[:slug]',
                            'constraints'   => array(
                                'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'      => array(
                            	'__NAMESPACE__' => 'Article\Controller',
                                'controller' => 'Article',
                                'action' => 'view'
                            ),
                        ),
                    ),
                ),
            ),
			'admin' => array(
				'child_routes' => array(
					'article' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'    => '/article[/:action[/id/[:id]]]',
							'constraints' => array(
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' 		 => '\d+'
							),
							'defaults' => array(
								'__NAMESPACE__' => 'Article\Controller',
								'controller'    => 'Article',
								'action'        => 'list',
							),
						),
					),
				),
			),
        ),
    ),
	'navigation' => array(
		'admin' => array(
			'article' => array(
				'label' => 'Article',
				'pages' => array(
					'list' => array(
						'label' => 'List All Articles',
						'action' => 'list',
						'route' => 'admin/article',
						'resource' => 'menu:user'
					),
					'add' => array(
						'label' => 'Add New Article',
						'action' => 'add',
						'route' => 'admin/article',
						'resource' => 'menu:user'
					)
				),
				'route' => 'admin/article',
				'resource' => 'menu:user'
			),
		),
	),
    'view_manager' => array(
    	'template_map' => array(
    		'article/article-form'	=> __DIR__ . '/../view/article/article/article-form.phtml',
    	),
        'template_path_stack' => array(
            'Article' => __DIR__ . '/../view',
        ),
    ),
);
