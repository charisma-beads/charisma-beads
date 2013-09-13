<?php
return array(
    'router' => array(
        'routes' => array(
            'shop' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/shop',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller'    => 'Shop',
                        'action'        => 'shop-front',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'catalog' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:categoryIdent]',
                            'constraints' => array(
                            	'categoryIdent' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                            	'controller'    => 'Catalog',
                            	'action'        => 'index',
                            	'categoryIdent' => ''
                            ),
                        ),
                    ),
                ),
            ),
        	'admin' => array(
        		'child_routes' => array(
        			'shop' => array(
        				'type'    => 'Segment',
        				'options' => array(
        					'route'    => '/shop',
        					'defaults' => array(
        						'__NAMESPACE__' => 'Shop\Controller',
        						'controller'    => 'Shop',
        						'action'        => 'index',
        					),
        				),
        			),
        		),
        	),
        ),
    ),
	'navigation' => array(
		'admin' => array(
			'shop' => array(
				'label' => 'Shop',
				'pages' => array(
					'overview' => array(
						'label' => 'Overview',
						'action' => 'index',
						'route' => 'admin/shop',
						'resource' => 'menu:admin'
					),
				),
				'route' => 'admin/shop',
				'resource' => 'menu:admin'
			),
		),
	),
    'view_manager' => array(
        'template_path_stack' => array(
            'Shop' => __DIR__ . '/../view',
        ),
    ),
);
