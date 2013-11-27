<?php
return array(
	'userAcl' => array(
		'userRoles' => array(
			'admin' => array(
				'privileges' => array(
					array('controller' => 'Navigation\Controller\Menu', 'action' => 'all'),
					array('controller' => 'Navigation\Controller\Page', 'action' => 'all'),
				),
			),
		),
		'userResources' => array(
			'Navigation\Controller\Menu',
			'Navigation\Controller\Page',
			'menu:admin', 'menu:guest', 'menu:user',
		),
	),
    'router' => array(
        'routes' => array(
        	'admin' => array(
        		'child_routes' => array(
        			'menu' => array(
        				'type'    => 'Segment',
        				'options' => array(
        					'route'    => '/menu[/:action[/id/[:id]]]',
        					'constraints' => array(
        						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
        						'id' 		 => '\d+'
        					),
        					'defaults' => array(
        						'__NAMESPACE__' => 'Navigation\Controller',
        						'controller'    => 'Menu',
        						'action'        => 'list',
        					    'force-ssl'     => 'ssl'
        					),
        				),
        			),
        			'page' => array(
        				'type'    => 'Segment',
        				'options' => array(
        					'route'    => '/page[/:action[/menuId/[:menuId]][/id/[:id]]]',
        					'constraints' => array(
        						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
        						'id' 		 => '\d+',
        						'menuId' 	 => '\d+'
        					),
        					'defaults' => array(
        						'__NAMESPACE__' => 'Navigation\Controller',
        						'controller'    => 'Page',
        						'action'        => 'list',
        					    'force-ssl'     => 'ssl'
        					),
        				),
        			),
        		),
        	),
        ),
    ),
	'navigation' => array(
		'admin' => array(
			'menu' => array(
            	'label' => 'Menu',
            	'pages' => array(
            		'list' => array(
            			'label' => 'List All Menus',
            			'action' => 'list',
            			'route' => 'admin/menu',
            			'resource' => 'menu:admin'
            		),
            		'add' => array(
            			'label' => 'Add New Menu',
            			'action' => 'add',
            			'route' => 'admin/menu',
            			'resource' => 'menu:admin'
            		)
            	),
            	'route' => 'admin/menu',
            	'resource' => 'menu:admin'
			),
		),
	),
    'view_manager' => array(
    	'template_map' => array(
    	    'navigation/tb-menu'        => __DIR__ . '/../view/navigation/tb-menu.phtml',
    		'navigation/tb-nested-menu' => __DIR__ . '/../view/navigation/tb-nested-menu.phtml',
    		'menu/menu-form' 			=> __DIR__ . '/../view/navigation/menu/menu-form.phtml',
            'page/page-form' 			=> __DIR__ . '/../view/navigation/page/page-form.phtml',
    	),
        'template_path_stack' => array(
            'Navigation' => __DIR__ . '/../view',
        ),
    ),
);
