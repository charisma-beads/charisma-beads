<?php
return array(
	'user' => array(
		'auth' => array(
			'dbTable' => '',
			'identity' => '',
			'credential' => '',
			'credentialTreatment' => ''
		),
	),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'User',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                	'default' => array(
                		'type' => 'Segment',
                		'options' => array(
                			'route' => '/[:action]',
                			'constraints' => array(
                				'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                			),
                			'defaults' => array(
                				'controller' => 'User',
                				'action' => 'index',
                			),
                		),
                	),
                	'register' => array(
                		'type' => 'Literal',
                		'options' => array(
                			'route' => '/register',
                			'defaults' => array(
                				'controller'    => 'User',
                				'action' => 'register',
                			),
                		),
                	),
                	'thank-you' => array(
                		'type' => 'Literal',
                		'options' => array(
                			'route' => '/thank-you',
                			'defaults' => array(
                				'controller'    => 'User',
                				'action' => 'thank-you',
                			),
                		),
                	),
                    'authenticate' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/authenticate',
							'defaults' => array(
								'controller'    => 'Auth',
								'action' => 'authenticate',
							),
						),
    				),
    				'logout' => array(
    					'type' => 'Literal',
    					'options' => array(
    						'route' => '/logout',
    						'defaults' => array(
    							'controller'    => 'Auth',
    							'action' => 'logout',
    						),
    					),
    				),
    				'login' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/login',
							'defaults' => array(
								'controller'    => 'Auth',
								'action' => 'login',
							),
						),
    				),
                ),
            ),
        	'admin' => array(
        		'child_routes' => array(
        			'user' => array(
        				'type'    => 'Segment',
        				'options' => array(
        					'route'    => '/user',
        					'defaults' => array(
        						'__NAMESPACE__' => 'User\Controller',
        						'controller'    => 'Admin',
        						'action'        => 'index',
        					),
        				),
        				'may_terminate' => true,
        				'child_routes' => array(
        					'edit' => array(
        						'type'    => 'Segment',
        						'options' => array(
        							'route'         => '/[:action[/id/[:id]]]',
        							'constraints'   => array(
        								'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
        								'id'		=> '\d+'
        							),
        							'defaults'      => array(
        								'action' => 'edit',
        							),
        						),
        					),
        					'page' => array(
        						'type'    => 'Segment',
        						'options' => array(
        							'route'         => '/page/[:page]',
        							'constraints'   => array(
        								'page'			=> '\d+'
        							),
        							'defaults'      => array(
        								'action' => 'list',
        								'page' => 1
        							),
        						),
        					),
        				),
        			),
        		),
        	),
        ),
    ),
	'navigation' => array(
		'admin' => array(
			'user' => array(
                'label' => 'User',
                'pages' => array(
                    'list' => array(
                        'label' => 'List All Users',
                        'action' => 'index',
                        'route' => 'admin/user',
                        'resource' => 'menu:admin'
                    ),
                    'add' => array(
                        'label' => 'Add New User',
                        'action' => 'add',
                        'route' => 'admin/user',
                        'resource' => 'menu:admin'
                    ),
                ),
                'route' => 'admin/user',
                'resource' => 'menu:admin'
            ),
		),
	),
    'view_manager' => array(
    	'template_map' => array(
    		'user/list'				=> __DIR__ . '/../view/user/admin/list.phtml',
    		'user/user-form'		=> __DIR__ . '/../view/user/user/user-form.phtml',
    		'admin/user/user-form'	=> __DIR__ . '/../view/user/admin/user-form.phtml',
    	),
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
);
