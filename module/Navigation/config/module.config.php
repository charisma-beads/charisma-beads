<?php
return array(
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
    		'navigation/tb-nested-menu' => __DIR__ . '/../view/navigation/tb-nested-menu.phtml',
    		'menu/menu-form' 			=> __DIR__ . '/../view/navigation/menu/menu-form.phtml',
            'page/page-form' 			=> __DIR__ . '/../view/navigation/page/page-form.phtml',
    	),
        'template_path_stack' => array(
            'Navigation' => __DIR__ . '/../view',
        ),
    ),
);
