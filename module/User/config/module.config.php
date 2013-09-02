<?php
return array(
	'user' => array(
		'auth' => array(
			'dbTable' => '',
			'identity' => '',
			'credential' => '',
			'hash' => ''
		),
	),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/user',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'User',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    
                ),
            ),
            'auth' => array(
        		'type' => 'Literal',
        		'options' => array(
    				'route' => '/auth',
    				'defaults' => array(
    				    '__NAMESPACE__' => 'User\Controller',
						'controller'    => 'Auth',
						'action'        => 'login',
    				),
        		),
        		'may_terminate' => true,
        		'child_routes' => array(
    				'authenticate' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/authenticate',
							'defaults' => array(
								'action' => 'authenticate',
							),
						),
    				),
    				'logout' => array(
    					'type' => 'Literal',
    					'options' => array(
    						'route' => '/logout',
    						'defaults' => array(
    							'action' => 'logout',
    						),
    					),
    				),
    				'login' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/login',
							'defaults' => array(
								'action' => 'login',
							),
						),
    				),
        		),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
);
