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
	'userAcl' => array(
		'userRoles' => array(
			'guest'			=> array(
				'label'			=> 'Guest',
				'parent'		=> null,
				'privileges'	=> array(
					array('controller' => 'User\Controller\Auth', 'action' => array('login', 'authenticate')),
					array('controller' => 'User\Controller\User', 'action' => array('register', 'thank-you')),
				),
				'resources' => array('menu:guest'),
			),
			'registered'    => array(
				'label'         => 'User',
				'parent'        => null,
				'privileges'    => array(
					array('controller' => 'User\Controller\Auth', 'action' => array('logout')),
					array('controller' => 'User\Controller\User', 'action' => array('edit')),
				),
				'resources' => array('menu:user')
			),
			'admin'        => array(
				'label'         => 'Admin',
				'parent'        => 'registered',
				'privileges'    => array(
					array('controller' => 'User\Controller\Admin', 'action' => 'all'),
				),
				'resources' => array('menu:admin'),
			),
		),
		'userResources' => array(
			'User\Controller\Admin',
			'User\Controller\Auth',
			'User\Controller\User',
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
                        'force-ssl'     => 'ssl'
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
                				'controller'    => 'User',
                				'action'        => 'index',
                			    'force-ssl'     => 'ssl'
                			),
                		),
                	),
                	'register' => array(
                		'type' => 'Literal',
                		'options' => array(
                			'route' => '/register',
                			'defaults' => array(
                				'controller'    => 'User',
                				'action'        => 'register',
                			    'force-ssl'     => 'ssl'
                			),
                		),
                	),
                	'thank-you' => array(
                		'type' => 'Literal',
                		'options' => array(
                			'route' => '/thank-you',
                			'defaults' => array(
                				'controller'    => 'User',
                				'action'        => 'thank-you',
                			    'force-ssl'     => 'ssl'
                			),
                		),
                	),
                    'authenticate' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/authenticate',
							'defaults' => array(
								'controller'    => 'Auth',
								'action'        => 'authenticate',
							    'force-ssl'     => 'ssl'
							),
						),
    				),
    				'logout' => array(
    					'type' => 'Literal',
    					'options' => array(
    						'route' => '/logout',
    						'defaults' => array(
    							'controller'    => 'Auth',
    							'action'        => 'logout',
    						    'force-ssl'     => 'ssl'
    						),
    					),
    				),
    				'login' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/login',
							'defaults' => array(
								'controller'    => 'Auth',
								'action'        => 'login',
							    'force-ssl'     => 'ssl'
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
        					    'force-ssl'     => 'ssl'
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
        								'action'        => 'edit',
        							    'force-ssl'     => 'ssl'
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
        								'action'        => 'list',
        								'page'          => 1,
        							    'force-ssl'     => 'ssl'
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
                        'route' => 'admin/user/edit',
                        'resource' => 'menu:admin'
                    ),
                ),
                'route' => 'admin/user',
                'resource' => 'menu:admin'
            ),
		),
	),
    'view_manager' => array(
    	'template_map' => include __DIR__  .'/../template_map.php',
    ),
);
