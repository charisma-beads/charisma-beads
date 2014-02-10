<?php
return array(
    'shop' => array(
        'checkout_options'  => array(
            'payCheck'          => true,
            'collectInstore'    => true,
            'payCreditCard'     => true,
            'payPhone'          => true,
            'payPaypal'         => true,
        ),
        'paypal_options'    => array(
            'cancelReturnUrl'   => '',
            'currentyCode'      => '',
            'deploy'            => 'test',
            'imageUrl'          => '',
            'ipnLog'            => '',
            'merchantId'        => '',
            'notifyUrl'         => '',
            'paypalIPN'         => true,
            'returnUrl'         => '',
            'returnMethod'      => '',
        ),
        'shop_options'      => array(
            'alert'             => false,
            'alertText'         => '',
            'orderEmail'        => '',
            'postState'         => false,
            'productsPerPage'   => 24,
            'stockControl'      => false,
            'vatNumber'         => '',
            'vatState'          => false,
        ),
        'cart_cookie'       => array(
            'expiry'            => 3600,            // Cookie expiry time in mins
            'domain'            => null,            // Set to null this defaults to the current domain
            'secure'            => false,           // Should the cookie be secure only?
            'url'               => '/',             // Location to set in the cookie - default to root
            'cookieName'        => 'ShoppingCart'   // Cookie Name
        )
    ),
	'userAcl' => array(
		'userRoles' => array(
			'guest' => array(
				'privileges' => array(
					array('controller' => 'Shop\Controller\Cart', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Catalog', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Checkout', 'action' => array('index')),
					array('controller' => 'Shop\Controller\Paypal', 'action' => array('ipn')),
					array('controller' => 'Shop\Controller\Product', 'action' => array('view')),
					array('controller' => 'Shop\Controller\Shop', 'action' => array('shop-front')),
				),
			),
			'registered' => array(
				'privileges' => array(
					array('controller' => 'Shop\Controller\Cart', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Catalog', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Checkout', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Payment', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Paypal', 'action' => array('process', 'success', 'cancel')),
					array('controller' => 'Shop\Controller\Product', 'action' => array('view')),
					array('controller' => 'Shop\Controller\Shop', 'action' => array('shop-front')),
				),
			),
			'admin' => array(
				'privileges' => array(
				    array('controller' => 'Shop\Controller\Country', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\Customer', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\Order', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\PostCost', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\PostLevel', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\PostUnit', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\PostZone', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Product', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\ProductCategory', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\ProductImage', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\ProductGroupPrice', 'action' => 'all'),
					array('controller' => 'Shop\Controller\Shop', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\TaxCode', 'action' => 'all'),
				    array('controller' => 'Shop\Controller\TaxRate', 'action' => 'all'),
				),
			),
		),
		'userResources' => array(
			'Shop\Controller\Cart',
            'Shop\Controller\Catalog',
            'Shop\Controller\Checkout',
            'Shop\Controller\Country',
            'Shop\Controller\Customer',
            'Shop\Controller\Order',
            'Shop\Controller\Payment',
            'Shop\Controller\Paypal',
		    'Shop\Controller\PostCost',
		    'Shop\Controller\PostLevel',
		    'Shop\Controller\PostUnit',
            'Shop\Controller\PostZone',
            'Shop\Controller\Product',
            'Shop\Controller\ProductCategory',
            'Shop\Controller\ProductImage',
		    'Shop\Controller\ProductGroupPrice',
            'Shop\Controller\Shop',
            'Shop\Controller\TaxCode',
            'Shop\Controller\TaxRate',
		)
	),
	'router' => array(
		'routes' => array(
			'shop' => array(
				'type' => 'Literal',
				'options'       => array(
					'route'    => '/shop',
					'defaults' => array(
						'__NAMESPACE__'   => 'Shop\Controller',
						'controller'      => 'Shop',
						'action'          => 'shop-front',
						'force-ssl'       => 'http'
					)
				),
				'may_terminate' => true,
				'child_routes'  => array(
				    
					'catalog'  => array(
						'type'    => 'Segment',
						'options' => array(
							'route'          => '[/:categoryIdent]',
							'constraints'    => array(
								'categoryIdent' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
							),
							'defaults'       => array(
								'controller'    => 'Catalog',
								'action'        => 'index',
								'categoryIdent' => '',
								'force-ssl'     => 'http'
							)
						),
						'may_terminate' => true,
						'child_routes' => array(
							'product' => array(
								'type' => 'Segment',
								'options' => array(
									'route' => '/[:productIdent]',
									'constraints' => array(
										'productIdent' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
									),
									'defaults' => array(
										'action' => 'view',
										'productIdent' => '',
										'force-ssl' => 'http'
									),
								),
							),
							'page' => array(
								'type' => 'Segment',
								'options' => array(
									'route' => '/page/[:page]',
									'constraints' => array(
										'page' => '\d+'
									),
									'defaults' => array(
										'page' => 1,
										'force-ssl' => 'http'
									),
								),
							),
						),
					),
				    'search' => array(
				        'type' => 'Segment',
				        'options' => array(
				            'route' => '/search',
				            'defaults' => array(
				                'controller' => 'Catalog',
				                'action' => 'search',
				                'force-ssl' => 'http'
				            )
				        ),
				        'may_terminate' => true,
				        'child_routes' => array(
				            'page' => array(
				                'type' => 'Segment',
				                'options' => array(
				                    'route' => '/page/[:page]',
				                    'constraints' => array(
				                        'page' => '\d+'
				                    ),
				                    'defaults' => array(
				                        'page' => 1,
				                        'force-ssl' => 'http'
				                    ),
				                ),
				            ),
				        ),
				    ),
					'cart' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/cart/[:action[/[:id]]]',
							'constraints' => array(
								'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
								'id' => '\d+'
							),
							'defaults' => array(
								'controller' => 'Cart',
								'action' => 'view',
								'force-ssl' => 'http'
							)
						)
					),
					'checkout' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/checkout[/:action]',
							'constraints' => array(
								'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
							),
							'defaults' => array(
								'controller' => 'Checkout',
								'action' => 'index',
								'force-ssl' => 'ssl'
							)
						)
					),
					'payment' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/payment[/:action]',
							'constraints' => array(
                                'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                            ),
						    'defaults' => array(
								'controller' => 'Payment',
						        'force-ssl' => 'ssl'
							)
						)
					),
					'paypal' => array(
					    'type' => 'Segment',
					    'options' => array(
					        'route' => '/paypal[/:action]',
					        'constraints' => array(
					            'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                            ),
					        'defaults' => array(
					        	'controller' => 'Paypal',
					            'force-ssl' => 'ssl'
					        )
					    )
					)
				)
			),
			'admin' => array(
				'child_routes' => array(
					'shop' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'      => '/shop',
							'defaults'   => array(
								'__NAMESPACE__' => 'Shop\Controller',
								'controller'    => 'Shop',
								'action'        => 'index',
								'force-ssl'     => 'ssl'
							),
						),
					    'may_terminate'    => true,
					    'child_routes' => array(
					        'product' => array(
					            'type'     => 'Segment',
    					        'options'  => array(
                                    'route'     => '/product',
    					            'defaults' => array(
    					                'controller'   => 'Product',
    					                'action'       => 'index',
    					                'force-ssl'    => 'ssl',
                                    ),
                                ),
					            'may_terminate'    => true,
					            'child_routes'     => array(
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
					        'category' => array(
					        	'type'     => 'Segment',
					        	'options'  => array(
					        		'route'     => '/category',
					        		'defaults' => array(
					        			'controller'   => 'ProductCategory',
					        			'action'       => 'index',
					        			'force-ssl'    => 'ssl',
					        		),
					        	),
					        	'may_terminate'    => true,
					        	'child_routes'     => array(
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
					    	'group-price' => array(
					    		'type'     => 'Segment',
					    		'options'  => array(
					    			'route'     => '/group-price',
					    			'defaults' => array(
					    				'controller'   => 'ProductGroupPrice',
					    				'action'       => 'index',
					    				'force-ssl'    => 'ssl',
					    			),
					    		),
					    		'may_terminate'    => true,
					    		'child_routes'     => array(
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
					        'image' => array(
					        	'type'     => 'Segment',
					        	'options'  => array(
					        		'route'     => '/image',
					        		'defaults' => array(
					        			'controller'   => 'ProductImage',
					        			'action'       => 'index',
					        			'force-ssl'    => 'ssl',
					        		),
					        	),
					        	'may_terminate'    => true,
					        	'child_routes'     => array(
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
					        'country' => array(
					        	'type'     => 'Segment',
					        	'options'  => array(
					        		'route'     => '/country',
					        		'defaults' => array(
					        			'controller'   => 'Country',
					        			'action'       => 'index',
					        			'force-ssl'    => 'ssl',
					        		),
					        	),
					        	'may_terminate'    => true,
					        	'child_routes'     => array(
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
					        'customer' => array(
					        	'type'     => 'Segment',
					        	'options'  => array(
					        		'route'     => '/customer',
					        		'defaults' => array(
					        			'controller'   => 'Customer',
					        			'action'       => 'index',
					        			'force-ssl'    => 'ssl',
					        		),
					        	),
					        	'may_terminate'    => true,
					        	'child_routes'     => array(
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
					        'order' => array(
					        	'type'     => 'Segment',
					        	'options'  => array(
					        		'route'     => '/order',
					        		'defaults' => array(
					        			'controller'   => 'Order',
					        			'action'       => 'index',
					        			'force-ssl'    => 'ssl',
					        		),
					        	),
					        	'may_terminate'    => true,
					        	'child_routes'     => array(
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
					        'post' => array(
					        	'type'     => 'Segment',
					        	'options'  => array(
					        		'route'     => '/post',
					        		'defaults' => array(
					        			'action'       => 'index',
					        			'force-ssl'    => 'ssl',
					        		),
					        	),
					        	'may_terminate'    => true,
					        	'child_routes'     => array(
					        	    'cost' => array(
					        	    	'type'     => 'Segment',
					        	    	'options'  => array(
					        	    		'route'     => '/cost',
					        	    		'defaults' => array(
					        	    			'controller'   => 'PostCost',
					        	    			'action'       => 'index',
					        	    			'force-ssl'    => 'ssl',
					        	    		),
					        	    	),
					        	    	'may_terminate'    => true,
					        	    	'child_routes'     => array(
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
					        	    'level' => array(
					        	    	'type'     => 'Segment',
					        	    	'options'  => array(
					        	    		'route'     => '/level',
					        	    		'defaults' => array(
					        	    			'controller'   => 'PostLevel',
					        	    			'action'       => 'index',
					        	    			'force-ssl'    => 'ssl',
					        	    		),
					        	    	),
					        	    	'may_terminate'    => true,
					        	    	'child_routes'     => array(
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
					        	    'zone' => array(
					        	    	'type'     => 'Segment',
					        	    	'options'  => array(
					        	    		'route'     => '/zone',
					        	    		'defaults' => array(
					        	    			'controller'   => 'PostZone',
					        	    			'action'       => 'index',
					        	    			'force-ssl'    => 'ssl',
					        	    		),
					        	    	),
					        	    	'may_terminate'    => true,
					        	    	'child_routes'     => array(
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
					        		'unit' => array(
					        			'type'     => 'Segment',
					        			'options'  => array(
					        				'route'     => '/unit',
					        				'defaults' => array(
					        					'controller'   => 'PostUnit',
					        					'action'       => 'index',
					        					'force-ssl'    => 'ssl',
					        				),
					        			),
					        			'may_terminate'    => true,
					        			'child_routes'     => array(
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
					        'tax' => array(
					        	'type'     => 'Segment',
					        	'options'  => array(
					        		'route'     => '/tax',
					        		'defaults' => array(
					        			'action'       => 'index',
					        			'force-ssl'    => 'ssl',
					        		),
					        	),
					        	'may_terminate'    => true,
					        	'child_routes'     => array(
					        	    'code' => array(
					        	    	'type'     => 'Segment',
					        	    	'options'  => array(
					        	    		'route'     => '/code',
					        	    		'defaults' => array(
					        	    			'controller'   => 'TaxCode',
					        	    			'action'       => 'index',
					        	    			'force-ssl'    => 'ssl',
					        	    		),
					        	    	),
					        	    	'may_terminate'    => true,
					        	    	'child_routes'     => array(
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
					        	    'rate' => array(
					        	    	'type'     => 'Segment',
					        	    	'options'  => array(
					        	    		'route'     => '/rate',
					        	    		'defaults' => array(
					        	    			'controller'   => 'TaxRate',
					        	    			'action'       => 'index',
					        	    			'force-ssl'    => 'ssl',
					        	    		),
					        	    	),
					        	    	'may_terminate'    => true,
					        	    	'child_routes'     => array(
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
				    'products' => array(
				    	'label' => 'Products',
				    	'action' => 'index',
				    	'route' => 'admin/shop/product',
				    	'resource' => 'menu:admin',
				        'pages' => array(
				            'list' => array(
				            	'label' => 'List All Products',
				            	'action' => 'index',
				            	'route' => 'admin/shop/product',
				            	'resource' => 'menu:admin'
				            ),
				            'add' => array(
				            	'label' => 'Add New Product',
				            	'action' => 'add',
				            	'route' => 'admin/shop/product/edit',
				            	'resource' => 'menu:admin'
				            ),
			        		'categories' => array(
		        				'label' => 'Categories',
		        				'action' => 'index',
		        				'route' => 'admin/shop/category',
		        				'resource' => 'menu:admin',
		        				'pages' => array(
	        						'list' => array(
        								'label' => 'List All Categories',
        								'action' => 'index',
        								'route' => 'admin/shop/category',
        								'resource' => 'menu:admin'
	        						),
	        						'add' => array(
        								'label' => 'Add New Category',
        								'action' => 'add',
        								'route' => 'admin/shop/category/edit',
        								'resource' => 'menu:admin'
	        						),
			        			),
			        		),
			        		'images' => array(
		        				'label' => 'Images',
		        				'action' => 'index',
		        				'route' => 'admin/shop/image',
		        				'resource' => 'menu:admin',
		        				'pages' => array(
	        						'list' => array(
        								'label' => 'List All Images',
        								'action' => 'index',
        								'route' => 'admin/shop/image',
        								'resource' => 'menu:admin'
	        						),
	        						'add' => array(
        								'label' => 'Add New Image',
        								'action' => 'add',
        								'route' => 'admin/shop/image/edit',
        								'resource' => 'menu:admin'
	        						),
		        				),
			        		),
				        	'group-prices' => array(
				        		'label' => 'Group Prices',
				        		'action' => 'index',
				        		'route' => 'admin/shop/group-price',
				        		'resource' => 'menu:admin',
				        		'pages' => array(
				        			'list' => array(
				        				'label' => 'List All Group Prices',
				        				'action' => 'index',
				        				'route' => 'admin/shop/group-price',
				        				'resource' => 'menu:admin'
				        			),
				        			'add' => array(
				        				'label' => 'Add New Group Price',
				        				'action' => 'add',
				        				'route' => 'admin/shop/group-price/edit',
				        				'resource' => 'menu:admin'
				        			),
				        		),
				        	),
				        ),
				    ),
				    'customers' => array(
				    	'label' => 'Customers',
				    	'action' => 'index',
				    	'route' => 'admin/shop/customer',
				    	'resource' => 'menu:admin',
				    	'pages' => array(
				    		'list' => array(
				    			'label' => 'List All Customers',
				    			'action' => 'index',
				    			'route' => 'admin/shop/customer',
				    			'resource' => 'menu:admin'
				    		),
				    		'add' => array(
				    			'label' => 'Add New Customer',
				    			'action' => 'add',
				    			'route' => 'admin/shop/customer/edit',
				    			'resource' => 'menu:admin'
				    		),
				    	)
				    ),
				    'orders' => array(
				    	'label' => 'Orders',
				    	'action' => 'index',
				    	'route' => 'admin/shop/order',
				    	'resource' => 'menu:admin',
				    	'pages' => array(
				    		'list' => array(
				    			'label' => 'List All Orders',
				    			'action' => 'index',
				    			'route' => 'admin/shop/order',
				    			'resource' => 'menu:admin'
				    		),
				    		'add' => array(
				    			'label' => 'Add New Order',
				    			'action' => 'add',
				    			'route' => 'admin/shop/order/edit',
				    			'resource' => 'menu:admin'
				    		),
				    	)
				    ),
				    'postage' => array(
				    	'label' => 'Postage',
				    	'action' => 'index',
				    	'route' => 'admin/shop/post',
				    	'resource' => 'menu:admin',
				    	'pages' => array(
				    	    'zones' => array(
				    	    	'label' => 'Zones',
				    	    	'action' => 'index',
				    	    	'route' => 'admin/shop/post/zone',
				    	    	'resource' => 'menu:admin',
				    	    	'pages' => array(
				    	    		'edit' => array(
				    	    			'label' => 'List All Zones',
				    	    			'action' => 'index',
				    	    			'route' => 'admin/shop/post/zone',
				    	    			'resource' => 'menu:admin'
				    	    		),
				    	    		'add' => array(
				    	    			'label' => 'Add New Zone',
				    	    			'action' => 'add',
				    	    			'route' => 'admin/shop/post/zone/edit',
				    	    			'resource' => 'menu:admin'
				    	    		),
				    	    	),
				    	    ),
				    		'countries' => array(
			    				'label' => 'Countries',
			    				'action' => 'index',
			    				'route' => 'admin/shop/country',
			    				'resource' => 'menu:admin',
			    				'pages' => array(
			    					'edit' => array(
			    						'label' => 'List All Countries',
			    						'action' => 'index',
			    						'route' => 'admin/shop/country',
			    						'resource' => 'menu:admin'
			    					),
			    					'add' => array(
			    						'label' => 'Add New Country',
			    						'action' => 'add',
			    						'route' => 'admin/shop/country/edit',
			    						'resource' => 'menu:admin'
			    					),
			    				),
			    			),
			    			'levels' => array(
			    				'label' => 'Postage Levels',
			    				'action' => 'index',
			    				'route' => 'admin/shop/post/level',
			    				'resource' => 'menu:admin',
			    				'pages' => array(
			    					'edit' => array(
			    						'label' => 'List All Postage Levels',
			    						'action' => 'index',
			    						'route' => 'admin/shop/post/level',
			    						'resource' => 'menu:admin'
			    					),
			    					'add' => array(
			    						'label' => 'Add New Postage Level',
			    						'action' => 'add',
			    						'route' => 'admin/shop/post/level/edit',
			    						'resource' => 'menu:admin'
			    					),
			    				),
			    			),
			    			'costs' => array(
			    				'label' => 'Postage Costs',
			    				'action' => 'index',
			    				'route' => 'admin/shop/post/cost',
			    				'resource' => 'menu:admin',
			    				'pages' => array(
			    					'edit' => array(
			    						'label' => 'List All Postage Costs',
			    						'action' => 'index',
			    						'route' => 'admin/shop/post/cost',
			    						'resource' => 'menu:admin'
			    					),
			    					'add' => array(
			    						'label' => 'Add New Postage Cost',
			    						'action' => 'add',
			    						'route' => 'admin/shop/post/cost/edit',
			    						'resource' => 'menu:admin'
			    					),
			    				),
			    			),
			    			'units' => array(
			    				'label' => 'Postage Units',
			    				'action' => 'index',
			    				'route' => 'admin/shop/post/unit',
			    				'resource' => 'menu:admin',
			    				'pages' => array(
			    					'edit' => array(
			    						'label' => 'List All Postage Units',
			    						'action' => 'index',
			    						'route' => 'admin/shop/post/unit',
			    						'resource' => 'menu:admin'
			    					),
			    					'add' => array(
			    						'label' => 'Add New Postage Unit',
			    						'action' => 'add',
			    						'route' => 'admin/shop/post/unit/edit',
			    						'resource' => 'menu:admin'
			    					),
			    				),
			    			),
				    	),
				    ),
				    'tax' => array(
				    	'label' => 'Tax',
				    	'action' => 'index',
				    	'route' => 'admin/shop/tax',
				    	'resource' => 'menu:admin',
				    	'pages' => array(
				    		'rates' => array(
				    	    	'label' => 'Rates',
				    	    	'action' => 'index',
				    	    	'route' => 'admin/shop/tax/rate',
				    	    	'resource' => 'menu:admin',
				    	    	'pages' => array(
				    	    		'edit' => array(
				    	    			'label' => 'List All Tax Rates',
				    	    			'action' => 'index',
				    	    			'route' => 'admin/shop/tax/rate',
				    	    			'resource' => 'menu:admin'
				    	    		),
				    	    		'add' => array(
				    	    			'label' => 'Add New Tax Rate',
				    	    			'action' => 'add',
				    	    			'route' => 'admin/shop/tax/rate/edit',
				    	    			'resource' => 'menu:admin'
				    	    		),
				    	    	),
				    	    ),
				    	    'codes' => array(
				    	    	'label' => 'Codes',
				    	    	'action' => 'index',
				    	    	'route' => 'admin/shop/tax/code',
				    	    	'resource' => 'menu:admin',
				    	    	'pages' => array(
				    	    		'edit' => array(
				    	    			'label' => 'List All Tax Codes',
				    	    			'action' => 'index',
				    	    			'route' => 'admin/shop/tax/code',
				    	    			'resource' => 'menu:admin'
				    	    		),
				    	    		'add' => array(
				    	    			'label'		=> 'Add New Tax Code',
				    	    			'action'	=> 'add',
				    	    			'route' 	=> 'admin/shop/tax/code/edit',
				    	    			'resource'	=> 'menu:admin'
				    	    		),
				    	    	),
				    	    ),
				    	),
				    ),
				),
				'route'		=> 'admin/shop',
				'resource'	=> 'menu:admin'
			)
		)
	),
	'view_manager' => array(
		'template_map' => array(
			'cart/summary'	=> __DIR__ . '/../view/shop/cart/cart-summary.phtml',
			'shop/cart'		=> __DIR__ . '/../view/shop/cart/cart.phtml',
		),
		'template_path_stack' => array(
			'Shop' => __DIR__ . '/../view'
		)
	)
);
