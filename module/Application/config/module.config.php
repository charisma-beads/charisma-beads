<?php

return array(
	'userAcl' => array(
		'userRoles' => array(
			'guest'	=>array(
				'privileges' => array(
					array('controller' => 'Application\Controller\Index', 'action' => array('index')),
				),
			),
			'registered' => array(
				'privileges' => array(
					array('controller' => 'Application\Controller\Index', 'action' => array('index')),
				),
			),
			'admin' => array(
				'privileges' => array(
					array('controller' => 'Application\Controller\Admin', 'action' => 'all'),
					array('controller' => 'Application\Controller\SessionManager', 'action' => 'all'),
				),
			),
		),
		'userResources' => array(
			'Application\Controller\Admin',
			'Application\Controller\Index',
			'Application\Controller\SessionManager',
		),
	),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Application\Controller',
                        'controller' 	=> 'Index',
                        'action'     	=> 'index',
                        'force-ssl'     => 'http'
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'force-ssl'     => 'http'
                    ),
                ),
            ),
            'admin' => array(
            	'child_routes' => array(
            		'application' => array(
            			'type'    => 'Segment',
            			'options' => array(
            				'route'    => '/application',
            				'defaults' => array(
            					'__NAMESPACE__' => 'Application\Controller',
                        		'controller'    => 'Admin',
                        		'action'        => 'dashboard',
            				    'force-ssl'     => 'ssl'
            				),
            			),
            		),
            		'session' => array(
	            		'type'    => 'Segment',
	            		'options' => array(
	            			'route'    => '/session',
	            			'defaults' => array(
	            				'__NAMESPACE__' => 'Application\Controller',
	            				'controller'    => 'SessionManager',
	            				'action'        => 'index',
	            			    'force-ssl'     => 'ssl'
	            			),
	            		),
	            		'may_terminate' => true,
	            		'child_routes' => array(
	            			'delete' => array(
	            				'type' => 'Segment',
	            				'options' => array(
	            					'route' => '/delete',
									'defaults' => array(
	            						'action'     => 'delete',
									    'force-ssl'  => 'ssl'
	            					)
	            				),
	            			),
	            			'view' => array(
	            				'type'    => 'Segment',
	            				'options' => array(
	            					'route'         => '/id/[:id]',
	            					'constraints'   => array(
	            						//'id'		=> '\d+'
	            					),
	            					'defaults'      => array(
	            						'action'     => 'view',
	            					    'force-ssl'  => 'ssl'
	            					),
	            				),
	            			),
	            			'list' => array(
	            				'type'    => 'Segment',
	            				'options' => array(
	            					'route'         => '/list',
	            					'defaults'      => array(
	            						'action'     => 'list',
	            					    'force-ssl'  => 'ssl'
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
	            						'action'     => 'list',
	            						'page'       => 1,
	            					    'force-ssl'  => 'ssl'
	            					),
	            				),
	            			),
	            		),
            		),
            	),
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'mail/queue/send' => array(
                    'options' => array(
                        'route' => 'mailqueue send', 
                        'defaults' => array(
                            '__NAMESPACE__' => 'Application\Controller',
                            'controller' => 'MailQueue',
                            'action' => 'send'
                        ),
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
    	'admin' => array(
    		'dashboard' => array(
    			'label' => 'Dashboard',
    			'route' => 'admin',
    			'resource' => 'menu:admin',
    			'pages' => array(
	    			'overview' => array(
	    				'label' => 'Overview',
	    				'route' => 'admin',
	    				'resource' => 'menu:admin',
	    			),
    				'sessionManager' => array(
						'label' => 'Session Manager',
						'route' => 'admin/session',
						'resource' => 'menu:admin',
					),
    			),
    		),
    	),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           	=> __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' 	=> __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               	=> __DIR__ . '/../view/error/404.phtml',
            'error/index'             	=> __DIR__ . '/../view/error/index.phtml',
            'paginate'					=> __DIR__ . '/../view/layout/paginate.phtml',
            'session/list'				=> __DIR__ . '/../view/application/session-manager/list.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
