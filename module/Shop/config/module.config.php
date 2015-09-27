<?php
return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'css/uthando-admin.css' => [
                    'css/shop.css',
                ],
                'js/uthando-admin.js' => [
                    'js/shop.js',
                ],
            ],
            'paths' => [
                'Shop' => __DIR__ . '/../public',
            ],
        ],
    ],
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Shop\Controller\Cart' => ['action' => 'all'],
                                'Shop\Controller\Catalog' => ['action' => 'all'],
                                'Shop\Controller\Checkout' => ['action' => ['index']],
                                'Shop\Controller\Product' => ['action' => [ 'view']],
                                'Shop\Controller\Shop' => ['action' => ['shop-front']],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Shop\Controller\Checkout' => ['action' => 'all'],
                                'Shop\Controller\Country\Province' => ['action' => ['country-province-list']],
                                'Shop\Controller\Customer' => ['action' => ['my-details']],
                                'Shop\Controller\Customer\Address' => ['action' => ['my-addresses', 'edit-address', 'add-address', 'delete-address']],
                                'Shop\Controller\Order' => ['action' => ['cancel', 'my-orders', 'print', 'view']],
                                'Shop\Controller\Payment' => ['action' => 'all'],
                                'Shop\Controller\Paypal' => ['action' => ['process', 'success', 'cancel']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Shop\Controller\Advert' => ['action' => 'all'],
                                'Shop\Controller\Country' => ['action' => 'all'],
                                'Shop\Controller\Country\Province' => ['action' => 'all'],
                                'Shop\Controller\Customer' => ['action' => 'all'],
                                'Shop\Controller\Customer\Address' => ['action' => 'all'],
                                'Shop\Controller\Order' => ['action' => 'all'],
                                'Shop\Controller\Post\Cost' => ['action' => 'all'],
                                'Shop\Controller\Post\Level' => ['action' => 'all'],
                                'Shop\Controller\Post\Unit' => ['action' => 'all'],
                                'Shop\Controller\Post\Zone' => ['action' => 'all'],
                                'Shop\Controller\Product' => ['action' => 'all'],
                                'Shop\Controller\Product\Category' => ['action' => 'all'],
                                'Shop\Controller\Product\Image' => ['action' => 'all'],
                                'Shop\Controller\Product\Group' => ['action' => 'all'],
                                'Shop\Controller\Product\Option' => ['action' => 'all'],
                                'Shop\Controller\Product\Size' => ['action' => 'all'],
                                'Shop\Controller\Shop' => ['action' => 'all'],
                                'Shop\Controller\Tax\Code' => ['action' => 'all'],
                                'Shop\Controller\Tax\Rate' => ['action' => 'all'],
                                'Shop\Controller\Report' => ['action' => 'all'],
                                'Shop\Controller\Settings' => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'Shop\Controller\Advert',
                'Shop\Controller\Cart',
                'Shop\Controller\Catalog',
                'Shop\Controller\Checkout',
                'Shop\Controller\Country',
                'Shop\Controller\Country\Province',
                'Shop\Controller\Customer',
                'Shop\Controller\Customer\Address',
                'Shop\Controller\Order',
                'Shop\Controller\Payment',
                'Shop\Controller\Paypal',
                'Shop\Controller\Post\Cost',
                'Shop\Controller\Post\Level',
                'Shop\Controller\Post\Unit',
                'Shop\Controller\Post\Zone',
                'Shop\Controller\Product',
                'Shop\Controller\Product\Category',
                'Shop\Controller\Product\Image',
                'Shop\Controller\Product\Group',
                'Shop\Controller\Product\Option',
                'Shop\Controller\Product\Size',
                'Shop\Controller\Shop',
                'Shop\Controller\Tax\Code',
                'Shop\Controller\Tax\Rate',
                'Shop\Controller\Report',
                'Shop\Controller\Settings',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Shop\Controller\Cart'                  => 'Shop\Controller\Cart\Cart',
            'Shop\Controller\Cart\Console'          => 'Shop\Controller\Cart\Console',
            'Shop\Controller\Country'               => 'Shop\Controller\Country\Country',
            'Shop\Controller\Country\Province'      => 'Shop\Controller\Country\CountryProvince',
            'Shop\Controller\Customer'              => 'Shop\Controller\Customer\Customer',
            'Shop\Controller\Customer\Address'      => 'Shop\Controller\Customer\CustomerAddress',
            'Shop\Controller\Order'                 => 'Shop\Controller\Order\Order',
            'Shop\Controller\Post\Cost'             => 'Shop\Controller\Post\PostCost',
            'Shop\Controller\Post\Level'            => 'Shop\Controller\Post\PostLevel',
            'Shop\Controller\Post\Unit'             => 'Shop\Controller\Post\PostUnit',
            'Shop\Controller\Post\Zone'             => 'Shop\Controller\Post\PostZone',
            'Shop\Controller\Product'               => 'Shop\Controller\Product\Product',
            'Shop\Controller\Product\Category'      => 'Shop\Controller\Product\ProductCategory',
            'Shop\Controller\Product\Image'         => 'Shop\Controller\Product\ProductImage',
            'Shop\Controller\Product\Group'         => 'Shop\Controller\Product\ProductGroup',
            'Shop\Controller\Product\Option'        => 'Shop\Controller\Product\ProductOption',
            'Shop\Controller\Product\Size'          => 'Shop\Controller\Product\ProductSize',
            'Shop\Controller\Tax\Code'              => 'Shop\Controller\Tax\TaxCode',
            'Shop\Controller\Tax\Rate'              => 'Shop\Controller\Tax\TaxRate',

            'Shop\Controller\Advert'                => 'Shop\Controller\Advert',
            'Shop\Controller\Catalog'               => 'Shop\Controller\Catalog',
            'Shop\Controller\Checkout'              => 'Shop\Controller\Checkout',
            'Shop\Controller\Payment'               => 'Shop\Controller\Payment',
            'Shop\Controller\Paypal'                => 'Shop\Controller\Paypal',
            'Shop\Controller\Report'                => 'Shop\Controller\Report',
            'Shop\Controller\Settings'              => 'Shop\Controller\Settings',
            'Shop\Controller\Shop'                  => 'Shop\Controller\Shop',
        ],
    ],
    'controller_plugins' => [
        'invokables' => [
            'Order' => 'Shop\Controller\Plugin\Order',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'ShopAdvert'            => 'Shop\Form\Advert',
            'ShopCartAdd'           => 'Shop\Form\Cart\Add',
            'ShopCatalogSearch'     => 'Shop\Form\Catalog\Search',
            'ShopCountry'           => 'Shop\Form\Country\Country',
            'ShopCountryProvince'   => 'Shop\Form\Country\Province',
            'ShopCustomer'          => 'Shop\Form\Customer\Customer',
            'ShopCustomerFieldSet'  => 'Shop\Form\Customer\CustomerFieldSet',
            'ShopCustomerAddress'   => 'Shop\Form\Customer\Address',
            'ShopAddressFieldSet'   => 'Shop\Form\Customer\AddressFieldSet',
            'ShopCustomerDetails'   => 'Shop\Form\Customer\CustomerDetails',
            'ShopOrder'             => 'Shop\Form\Order\Order',
            'ShopOrderConfirm'      => 'Shop\Form\Order\Confirm',
            'ShopOrderLineFieldSet' => 'Shop\Form\Order\LineFieldSet',
            'ShopOrderStatus'       => 'Shop\Form\Order\Status',
            'ShopPaymentCreditCard' => 'Shop\Form\Payment\CreditCard',
            'ShopPostCost'          => 'Shop\Form\Post\Cost',
            'ShopPostLevel'         => 'Shop\Form\Post\Level',
            'ShopPostUnit'          => 'Shop\Form\Post\Unit',
            'ShopPostZone'          => 'Shop\Form\Post\Zone',
            'ShopProduct'           => 'Shop\Form\Product\Product',
            'ShopProductCategory'   => 'Shop\Form\Product\Category',
            'ShopProductGroup'      => 'Shop\Form\Product\Group',
            'ShopProductImage'      => 'Shop\Form\Product\Image',
            'ShopProductOption'     => 'Shop\Form\Product\Option',
            'ShopProductSize'       => 'Shop\Form\Product\Size',
            'ShopTaxCode'           => 'Shop\Form\Tax\Code',
            'ShopTaxRate'           => 'Shop\Form\Tax\Rate',

            'ShopPaypalCredentialPairsFieldSet' => 'Shop\Form\Settings\Paypal\CredentialPairsFieldSet',
            'ShopPaypalCredentialSetFieldSet'   => 'Shop\Form\Settings\Paypal\CredentialSetFieldSet',
            'ShopSettings'                      => 'Shop\Form\Settings\Settings',
            'ShopFieldSet'                      => 'Shop\Form\Settings\ShopFieldSet',
            'ShopCartFieldSet'                  => 'Shop\Form\Settings\CartFieldSet',
            'ShopPaypalFieldSet'                => 'Shop\Form\Settings\PaypalFieldSet',
            'ShopReportsFieldSet'               => 'Shop\Form\Settings\ReportsFieldSet',
            'ShopCartCookieFieldSet'            => 'Shop\Form\Settings\CartCookieFieldSet',
            'ShopInvoiceFieldSet'               => 'Shop\Form\Settings\InvoiceFieldSet',
            'ShopOrderFieldSet'                 => 'Shop\Form\Settings\OrderFieldSet',

            'AdvertList'                => 'Shop\Form\Element\AdvertList',
            'CountryList'               => 'Shop\Form\Element\CountryList',
            'CountryProvinceList'       => 'Shop\Form\Element\CountryProvinceList',
            'CustomerAddressList'       => 'Shop\Form\Element\CustomerAddressList',
            'CustomerPrefixList'        => 'Shop\Form\Element\CustomerPrefixList',
            'MonthlyTotalYearList'      => 'Shop\Form\Element\MonthlyTotalYearList',
            'ShopPrice'                 => 'Shop\Form\Element\Number',
            'OrderStatusList'           => 'Shop\Form\Element\OrderStatusList',
            'PayOptionsList'            => 'Shop\Form\Element\PayOptionsList',
            'PostLevelList'             => 'Shop\Form\Element\PostLevelList',
            'PostUnitList'              => 'Shop\Form\Element\PostUnitList',
            'PostZoneList'              => 'Shop\Form\Element\PostZoneList',
            'ProductCategoryImageList'  => 'Shop\Form\Element\ProductCategoryImageList',
            'ProductCategoryList'       => 'Shop\Form\Element\ProductCategoryList',
            'ProductGroupList'          => 'Shop\Form\Element\ProductGroupList',
            'ProductOptionList'         => 'Shop\Form\Element\ProductOptionsList',
            'ProductSizeList'           => 'Shop\Form\Element\ProductSizeList',
            'TaxCodeList'               => 'Shop\Form\Element\TaxCodeList',
            'TaxRateList'               => 'Shop\Form\Element\TaxRateList',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'ShopAdvert'            => 'Shop\Hydrator\Advert\Advert',
            'ShopAdvertHit'         => 'Shop\Hydrator\Advert\Hit',
            'ShopCart'              => 'Shop\Hydrator\Cart\Cart',
            'ShopCartItem'          => 'Shop\Hydrator\Cart\Item',
            'ShopCountry'           => 'Shop\Hydrator\Country\Country',
            'ShopCountryProvince'   => 'Shop\Hydrator\Country\Province',
            'ShopCustomer'          => 'Shop\Hydrator\Customer\Customer',
            'ShopCustomerAddress'   => 'Shop\Hydrator\Customer\Address',
            'ShopCustomerPrefix'    => 'Shop\Hydrator\Customer\Prefix',
            'ShopOrder'             => 'Shop\Hydrator\Order\Order',
            'ShopOrderLine'         => 'Shop\Hydrator\Order\Line',
            'ShopOrderStatus'       => 'Shop\Hydrator\Order\Status',
            'ShopPaymentCreditCard' => 'Shop\Hydrator\Payment\CreditCard',
            'ShopPayPal'            => 'Shop\Hydrator\Paypal\PaypalHydrator',
            'ShopPayPalItemList'    => 'Shop\Hydrator\Paypal\ItemList',
            'ShopPayPalAggregate'   => 'Shop\Hydrator\Paypal\PaypalAggregate',
            'ShopPostCost'          => 'Shop\Hydrator\Post\Cost',
            'ShopPostLevel'         => 'Shop\Hydrator\Post\Level',
            'ShopPostUnit'          => 'Shop\Hydrator\Post\Unit',
            'ShopPostZone'          => 'Shop\Hydrator\Post\Zone',
            'ShopProduct'           => 'Shop\Hydrator\Product\Product',
            'ShopProductCategory'   => 'Shop\Hydrator\Product\Category',
            'ShopProductGroup'      => 'Shop\Hydrator\Product\Group',
            'ShopProductImage'      => 'Shop\Hydrator\Product\Image',
            'ShopProductOption'     => 'Shop\Hydrator\Product\Option',
            'ShopProductSize'       => 'Shop\Hydrator\Product\Size',
            'ShopTaxCode'           => 'Shop\Hydrator\Tax\Code',
            'ShopTaxRate'           => 'Shop\Hydrator\Tax\Rate',
        ],
    ],
    'input_filters' => [
        'shared'        => [
            'ShopCatalogSearch'     => true,
        ],
        'invokables' => [
            'ShopAdvert'            => 'Shop\InputFilter\Advert',
            'ShopCartAdd'           => 'Shop|InputFilter\Cart\Add',
            'ShopCatalogSearch'     => 'Shop\InputFilter\Catalog\Search',
            'ShopCountry'           => 'Shop\InputFilter\Country\Country',
            'ShopCountryProvince'   => 'Shop\InputFilter\Country\Province',
            'ShopCustomer'          => 'Shop\InputFilter\Customer\Customer',
            'ShopCustomerAddress'   => 'Shop\InputFilter\Customer\Address',
            'ShopOrder'             => 'Shop\InputFilter\Order\Order',
            'ShopOrderConfirm'      => 'Shop\InputFilter\Order\Confirm',
            'ShopOrderLine'         => 'Shop\InputFilter\Order\Line',
            'ShopOrderStatus'       => 'Shop\InputFilter\Order\Status',
            'ShopPaymentCreditCard' => 'Shop\InputFilter\Payment\CreditCard',
            'ShopPostCost'          => 'Shop\InputFilter\Post\Cost',
            'ShopPostLevel'         => 'Shop\InputFilter\Post\Level',
            'ShopPostUnit'          => 'Shop\InputFilter\Post\Unit',
            'ShopPostZone'          => 'Shop\InputFilter\Post\Zone',
            'ShopProduct'           => 'Shop\InputFilter\Product\Product',
            'ShopProductCategory'   => 'Shop\InputFilter\Product\Category',
            'ShopProductGroup'      => 'Shop\InputFilter\Product\Group',
            'ShopProductImage'      => 'Shop\InputFilter\Product\Image',
            'ShopProductOption'     => 'Shop\InputFilter\Product\Option',
            'ShopProductSize'       => 'Shop\InputFilter\Product\Size',
            'ShopTaxCode'           => 'Shop\InputFilter\Tax\Code',
            'ShopTaxRate'           => 'Shop\InputFilter\Tax\Rate',
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'Shop\Service\Report'       => 'Shop\Service\Report',
            'Shop\Service\StockControl' => 'Shop\Service\StockControl',
        ],
        'factories' => [
            'Shop\Options\CartCookie'   => 'Shop\Service\Factory\CartCookieOptions',
            'Shop\Options\Cart'         => 'Shop\Service\Factory\CartOptions',
            'Shop\Options\Invoice'      => 'Shop\Service\Factory\InvoiceOptions',
            'Shop\Options\Order'        => 'Shop\Service\Factory\OrderOptions',
            'Shop\Options\Paypal'       => 'Shop\Service\Factory\PaypalOptions',
            'Shop\Options\Reports'      => 'Shop\Service\Factory\ReportsOptions',
            'Shop\Options\Shop'         => 'Shop\Service\Factory\ShopOptions',

            'Shop\Service\Cart\Cookie'  => 'Shop\Service\Factory\CartCookie',
            'Shop\Service\Shipping'     => 'Shop\Service\Factory\Shipping',
            'Shop\Service\Tax'          => 'Shop\Service\Factory\Tax',
        ],
    ],
    'uthando_mappers' => [
        'invokables' => [
            'ShopAdvert'            => 'Shop\Mapper\Advert\Advert',
            'ShopAdvertHit'         => 'Shop\Mapper\Advert\Hit',
            'ShopCart'              => 'Shop\Mapper\Cart\Cart',
            'ShopCartItem'          => 'Shop\Mapper\Cart\Item',
            'ShopCountry'           => 'Shop\Mapper\Country\Country',
            'ShopCountryProvince'   => 'Shop\Mapper\Country\Province',
            'ShopCustomer'          => 'Shop\Mapper\Customer\Customer',
            'ShopCustomerAddress'   => 'Shop\Mapper\Customer\Address',
            'ShopCustomerPrefix'    => 'Shop\Mapper\Customer\Prefix',
            'ShopOrder'             => 'Shop\Mapper\Order\Order',
            'ShopOrderLine'         => 'Shop\Mapper\Order\Line',
            'ShopOrderStatus'       => 'Shop\Mapper\Order\Status',
            'ShopPostCost'          => 'Shop\Mapper\Post\Cost',
            'ShopPostLevel'         => 'Shop\Mapper\Post\Level',
            'ShopPostUnit'          => 'Shop\Mapper\Post\Unit',
            'ShopPostZone'          => 'Shop\Mapper\Post\Zone',
            'ShopProduct'           => 'Shop\Mapper\Product\Product',
            'ShopProductCategory'   => 'Shop\Mapper\Product\Category',
            'ShopProductGroup'      => 'Shop\Mapper\Product\Group',
            'ShopProductImage'      => 'Shop\Mapper\Product\Image',
            'ShopProductOption'     => 'Shop\Mapper\Product\Option',
            'ShopProductSize'       => 'Shop\Mapper\Product\Size',
            'ShopTaxCode'           => 'Shop\Mapper\Tax\Code',
            'ShopTaxRate'           => 'Shop\Mapper\Tax\Rate',
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'ShopAdvert'            => 'Shop\Model\Advert\Advert',
            'ShopAdvertHit'         => 'Shop\Model\Advert\Hit',
            'ShopCart'              => 'Shop\Model\Cart\Cart',
            'ShopCartItem'          => 'Shop\Model\Cart\Item',
            'ShopCountry'           => 'Shop\Model\Country\Country',
            'ShopCountryProvince'   => 'Shop\Model\Country\Province',
            'ShopCustomer'          => 'Shop\Model\Customer\Customer',
            'ShopCustomerAddress'   => 'Shop\Model\Customer\Address',
            'ShopCustomerPrefix'    => 'Shop\Model\Customer\Prefix',
            'ShopOrder'             => 'Shop\Model\Order\Order',
            'ShopOrderLine'         => 'Shop\Model\Order\Line',
            'ShopOrderMetaData'     => 'Shop\Model\Order\MetaData',
            'ShopOrderStatus'       => 'Shop\Model\Order\Status',
            'ShopPaymentCreditCard' => 'Shop\Model\Payment\CreditCard',
            'ShopPostCost'          => 'Shop\Model\Post\Cost',
            'ShopPostLevel'         => 'Shop\Model\Post\Level',
            'ShopPostUnit'          => 'Shop\Model\Post\Unit',
            'ShopPostZone'          => 'Shop\Model\Post\Zone',
            'ShopProduct'           => 'Shop\Model\Product\Product',
            'ShopProductCategory'   => 'Shop\Model\Product\Category',
            'ShopProductGroup'      => 'Shop\Model\Product\Group',
            'ShopProductImage'      => 'Shop\Model\Product\Image',
            'ShopProductMetaData'   => 'Shop\Model\Product\MetaData',
            'ShopProductOption'     => 'Shop\Model\Product\Option',
            'ShopProductSize'       => 'Shop\Model\Product\Size',
            'ShopTaxCode'           => 'Shop\Model\Tax\Code',
            'ShopTaxRate'           => 'Shop\Model\Tax\Rate',
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            'ShopAdvert'            => 'Shop\Service\Advert\Advert',
            'ShopAdvertHit'         => 'Shop\Service\Advert\Hit',
            'ShopCart'              => 'Shop\Service\Cart\Cart',
            'ShopCartItem'          => 'Shop\Service\Cart\Item',
            'ShopCountry'           => 'Shop\Service\Country\Country',
            'ShopCountryProvince'   => 'Shop\Service\Country\Province',
            'ShopCustomer'          => 'Shop\Service\Customer\Customer',
            'ShopCustomerAddress'   => 'Shop\Service\Customer\Address',
            'ShopCustomerPrefix'    => 'Shop\Service\Customer\Prefix',
            'ShopOrder'             => 'Shop\Service\Order\Order',
            'ShopOrderLine'         => 'Shop\Service\Order\Line',
            'ShopOrderStatus'       => 'Shop\Service\Order\Status',
            'ShopPaymentCreditCard' => 'Shop\Service\Payment\CreditCard',
            'ShopPaymentPaypal'     => 'Shop\Service\Payment\Paypal',
            'ShopPostCost'          => 'Shop\Service\Post\Cost',
            'ShopPostLevel'         => 'Shop\Service\Post\Level',
            'ShopPostUnit'          => 'Shop\Service\Post\Unit',
            'ShopPostZone'          => 'Shop\Service\Post\Zone',
            'ShopProduct'           => 'Shop\Service\Product\Product',
            'ShopProductCategory'   => 'Shop\Service\Product\Category',
            'ShopProductGroup'      => 'Shop\Service\Product\Group',
            'ShopProductImage'      => 'Shop\Service\Product\Image',
            'ShopProductOption'     => 'Shop\Service\Product\Option',
            'ShopProductSize'       => 'Shop\Service\Product\Size',
            'ShopTaxCode'           => 'Shop\Service\Tax\Code',
            'ShopTaxRate'           => 'Shop\Service\Tax\Rate',
        ],
    ],
    'validators' => [
        'invokables' => [
            'ShopPostCode'  => 'Shop\I18n\Validator\PostCode',
        ],
    ],
    'view_helpers' => [
        'invokables'    => [
            'ShopAlert'             => 'Shop\View\Alert',
            'BreadCrumbs'           => 'Shop\View\Breadcrumb',
            'CartOption'            => 'Shop\View\CartOption',
            'Cart'                  => 'Shop\View\Cart',
            'Category'              => 'Shop\View\Category',
            'CountrySelect'         => 'Shop\View\CountrySelect',
            'CustomerAddress'       => 'Shop\View\CustomerAddress',
            'MonthYearSelect'       => 'Shop\View\FormMonthSelect',
            'InvoiceOption'         => 'Shop\View\InvoiceOption',
            'NormaliseOrderNumber'  => 'Shop\View\NormaliseOrderNumber',
            'PercentFormat'         => 'Shop\View\PercentFormat',
            'PriceFormat'           => 'Shop\View\PriceFormat',
            'ProductHelper'         => 'Shop\View\Product',
            'ProductCategoryImage'  => 'Shop\View\ProductCategoryImage',
            'ProductImage'          => 'Shop\View\ProductImage',
            'ProductOptions'        => 'Shop\View\ProductOptions',
            'ProductPrice'          => 'Shop\View\ProductPrice',
            'ProductSearch'         => 'Shop\View\ProductSearch',
            'ProductTableRowState'  => 'Shop\View\ProductTableRowState',
            'ShopOption'            => 'Shop\View\ShopOption',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'cart/summary'         => __DIR__ . '/../view/shop/cart/cart-summary.phtml',
            'shop/cart'            => __DIR__ . '/../view/shop/cart/cart.phtml',
            'shop/order/details'   => __DIR__ . '/../view/shop/order/order-details.phtml'
        ],
        'template_path_stack' => [
            'shop' => __DIR__ . '/../view'
        ],
    ],
    'router' => [
        'routes' => [
            'shop' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/shop',
                    'defaults' => [
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Shop',
                        'action' => 'shop-front',
                        'force-ssl' => 'http'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'catalog' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '[/:categoryIdent]',
                            'constraints' => [
                                'categoryIdent' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => 'Catalog',
                                'action' => 'index',
                                'categoryIdent' => '',
                                'force-ssl' => 'http'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'product' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/[:productIdent]',
                                    'constraints' => [
                                        'productIdent' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'view',
                                        'productIdent' => '',
                                        'force-ssl' => 'http'
                                    ]
                                ]
                            ],
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'page' => 1,
                                        'force-ssl' => 'http'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'search' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/search',
                            'defaults' => [
                                'controller' => 'Catalog',
                                'action' => 'search',
                                'force-ssl' => 'http'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'page' => 1,
                                        'force-ssl' => 'http'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'cart' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/cart/[:action[/[:id]]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ],
                            'defaults' => [
                                'controller' => 'Cart',
                                'action' => 'view',
                                'force-ssl' => 'http'
                            ]
                        ]
                    ],
                    'checkout' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/checkout[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => 'Checkout',
                                'action' => 'index',
                                'force-ssl' => 'ssl'
                            ]
                        ]
                    ],
                    'customer' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/customer[/]',
                            'defaults' => [
                                'controller' => 'Customer',
                                'action' => 'my-details',
                                'force-ssl' => 'ssl'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'address' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'address[/][:action[/[:id][/[:return]]]]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '\d+',
                                    ],
                                    'defaults' => [
                                        'controller' => 'Customer\Address',
                                        'action' => 'my-addresses',
                                        'force-ssl' => 'ssl'
                            		],
                                ],
                            ],
                        ],
                    ],
                    'country' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/country/province',
                            'defaults' => [
                                'controller' => 'Country\Province',
                                'action' => 'country-province-list',
                                'force-ssl' => 'http',
                            ],
                        ],
                    ],
                    'order' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/order[/]',
                            'defaults' => [
                                'controller' => 'Order',
                                'action' => 'my-orders',
                                'force-ssl' => 'ssl'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'view' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'view/[:orderId]',
                                    'constraints' => [
                                        'orderId' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'view',
                                        'force-ssl' => 'ssl'
                                    ]
                                ]
                            ],
                            'print' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'print/[:orderId]',
                                    'constraints' => [
                                        'orderId' => '\d+'
                                    ],
                                    'defaults' => [
                                        'action' => 'print',
                                        'force-ssl' => 'ssl'
                                    ]
                                ]
                            ],
                            'page' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => 'page/[:page]',
                                    'constraints' => [
                                        'page' => '\d+'
                                    ],
                                    'defaults' => [
                                        'page' => 1,
                                        'force-ssl' => 'ssl'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'payment' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/payment',
                            'defaults' => [
                                'controller' => 'Payment',
                                'force-ssl' => 'ssl'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'default' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/:paymentOption',
                                    'constraints' => [
                                        'paymentOption' => '[a-zA-Z][a-zA-Z-]*',
                                    ],
                                    'defaults' => [
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                            'process-credit-card' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/process-credit-card/:orderId',
                                    'constraints' => [
                                        'orderId' => '\d+',
                                    ],
                                    'defaults' => [
                                        'action' => 'process-credit-card',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'paypal' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/paypal[/:action[/:orderId]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                                'orderId' => '\d+',
                            ],
                            'defaults' => [
                                'controller' => 'Paypal',
                                'force-ssl' => 'ssl',
                                'orderId' => 0,
                            ]
                        ]
                    ]
                ]
            ],
            'admin' => [
                'child_routes' => [
                    'shop' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/shop',
                            'defaults' => [
                                '__NAMESPACE__' => 'Shop\Controller',
                                'controller' => 'Shop',
                                'action' => 'index',
                                'force-ssl' => 'ssl'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'advert' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/advert',
                                    'defaults' => [
                                        'controller' => 'Advert',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'product' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/product',
                                    'defaults' => [
                                        'controller' => 'Product',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'image' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/image[/][:action[/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => 'Product\Image',
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'option' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/option[/][:action[/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => 'Product\Option',
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'size' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/size',
                                            'defaults' => [
                                                'controller' => 'Product\Size',
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'category' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/category',
                                    'defaults' => [
                                        'controller' => 'Product\Category',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'group' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/group',
                                    'defaults' => [
                                        'controller' => 'Product\Group',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'country' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/country',
                                    'defaults' => [
                                        'controller' => 'Country',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'province' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/province[/][:action[/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => 'Country\Province',
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'customer' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/customer',
                                    'defaults' => [
                                        'controller' => 'Customer',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'address' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/address[/][:action[/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+',
                                            ],
                                            'defaults' => [
                                                'controller' => 'Customer\Address',
                                                'action' => 'list',
                                                'force-ssl' => 'ssl'
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'order' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/order',
                                    'defaults' => [
                                        'controller' => 'Order',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/[:action[/id/[:id]]]',
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'edit',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ],
                                    'page' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/page/[:page]',
                                            'constraints' => [
                                                'page' => '\d+'
                                            ],
                                            'defaults' => [
                                                'action' => 'list',
                                                'page' => 1,
                                                'force-ssl' => 'ssl'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'post' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/post',
                                    'defaults' => [
                                        'controller' => 'Post\Cost',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'cost' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/cost',
                                            'defaults' => [
                                                'controller' => 'Post\Cost',
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'level' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/level',
                                            'defaults' => [
                                                'controller' => 'Post\Level',
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'zone' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/zone',
                                            'defaults' => [
                                                'controller' => 'Post\Zone',
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'unit' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/unit',
                                            'defaults' => [
                                                'controller' => 'Post\Unit',
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'tax' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/tax',
                                    'defaults' => [
                                        'controller' => 'Tax\Code',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'code' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/code',
                                            'defaults' => [
                                                'controller' => 'Tax\Code',
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    'rate' => [
                                        'type' => 'Segment',
                                        'options' => [
                                            'route' => '/rate',
                                            'defaults' => [
                                                'controller' => 'Tax\Rate',
                                                'action' => 'index',
                                                'force-ssl' => 'ssl'
                                            ]
                                        ],
                                        'may_terminate' => true,
                                        'child_routes' => [
                                            'edit' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/[:action[/id/[:id]]]',
                                                    'constraints' => [
                                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'edit',
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                            'page' => [
                                                'type' => 'Segment',
                                                'options' => [
                                                    'route' => '/page/[:page]',
                                                    'constraints' => [
                                                        'page' => '\d+'
                                                    ],
                                                    'defaults' => [
                                                        'action' => 'list',
                                                        'page' => 1,
                                                        'force-ssl' => 'ssl'
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'report' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/report[/:action[/:file]]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ],
                                    'defaults' => [
                                        'controller' => 'Report',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                            'settings' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/settings[/:action]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ],
                                    'defaults' => [
                                        'controller' => 'Settings',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'shop/cart/gc' => [
                    'options' => [
                        'route' => 'shopping-cart gc',
                        'defaults' => array(
                            '__NAMESPACE__' => 'Shop\Controller\Cart',
                            'controller' => 'Console',
                            'action' => 'gc'
                        ),
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'user' => [
            'orders' => [
                'label' => 'My Orders',
                'route' => 'shop/order',
                'resource' => 'menu:user'
            ],
            'details' => [
                'label' => 'My Details',
                'route' => 'shop/customer',
                'resource' => 'menu:user',
            ],
            'address' => [
                'label' => 'My Addresses',
                'route' => 'shop/customer/address',
                'resource' => 'menu:user'
            ]
        ],
        'admin' => [
            'shop' => [
                'label' => 'Shop',
                'pages' => [
                    'overview' => [
                        'label' => 'Overview',
                        'action' => 'index',
                        'route' => 'admin/shop',
                        'resource' => 'menu:admin'
                    ],
                    'products' => [
                        'label' => 'Products',
                        'action' => 'index',
                        'route' => 'admin/shop/product',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Products',
                                'action' => 'index',
                                'route' => 'admin/shop/product',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Product',
                                'action' => 'add',
                                'route' => 'admin/shop/product/edit',
                                'resource' => 'menu:admin'
                            ],
                            'categories' => [
                                'label' => 'Categories',
                                'action' => 'index',
                                'route' => 'admin/shop/category',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'list' => [
                                        'label' => 'List All Categories',
                                        'action' => 'index',
                                        'route' => 'admin/shop/category',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Category',
                                        'action' => 'add',
                                        'route' => 'admin/shop/category/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'sizes' => [
                                'label' => 'Product Sizes',
                                'action' => 'index',
                                'route' => 'admin/shop/product/size',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'list' => [
                                        'label' => 'List All Sizes',
                                        'action' => 'index',
                                        'route' => 'admin/shop/product/size',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Size',
                                        'action' => 'add',
                                        'route' => 'admin/shop/product/size/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'groups' => [
                                'label' => 'Groups',
                                'action' => 'index',
                                'route' => 'admin/shop/group',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'list' => [
                                        'label' => 'List All Group Prices',
                                        'action' => 'index',
                                        'route' => 'admin/shop/group',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Group Price',
                                        'action' => 'add',
                                        'route' => 'admin/shop/group/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                        ]
                    ],
                    'customers' => [
                        'label' => 'Customers',
                        'action' => 'index',
                        'route' => 'admin/shop/customer',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Customers',
                                'action' => 'index',
                                'route' => 'admin/shop/customer',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Customer',
                                'action' => 'add',
                                'route' => 'admin/shop/customer/edit',
                                'resource' => 'menu:admin'
                            ]
                        ]
                    ],
                    'orders' => [
                        'label' => 'Orders',
                        'action' => 'index',
                        'route' => 'admin/shop/order',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Orders',
                                'action' => 'index',
                                'route' => 'admin/shop/order',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Order',
                                'action' => 'add',
                                'route' => 'admin/shop/order/edit',
                                'resource' => 'menu:admin'
                            ]
                        ]
                    ],
                    'postage' => [
                        'label' => 'Postage',
                        'action' => 'index',
                        'route' => 'admin/shop/post',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'zones' => [
                                'label' => 'Zones',
                                'action' => 'index',
                                'route' => 'admin/shop/post/zone',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Zones',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/zone',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Zone',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/zone/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'countries' => [
                                'label' => 'Countries',
                                'action' => 'index',
                                'route' => 'admin/shop/country',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Countries',
                                        'action' => 'index',
                                        'route' => 'admin/shop/country',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Country',
                                        'action' => 'add',
                                        'route' => 'admin/shop/country/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'levels' => [
                                'label' => 'Postage Levels',
                                'action' => 'index',
                                'route' => 'admin/shop/post/level',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Postage Levels',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/level',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Level',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/level/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'costs' => [
                                'label' => 'Postage Costs',
                                'action' => 'index',
                                'route' => 'admin/shop/post/cost',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Postage Costs',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/cost',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Cost',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/cost/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'units' => [
                                'label' => 'Postage Units',
                                'action' => 'index',
                                'route' => 'admin/shop/post/unit',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Postage Units',
                                        'action' => 'index',
                                        'route' => 'admin/shop/post/unit',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Postage Unit',
                                        'action' => 'add',
                                        'route' => 'admin/shop/post/unit/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'tax' => [
                        'label' => 'Tax',
                        'action' => 'index',
                        'route' => 'admin/shop/tax',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'rates' => [
                                'label' => 'Rates',
                                'action' => 'index',
                                'route' => 'admin/shop/tax/rate',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Tax Rates',
                                        'action' => 'index',
                                        'route' => 'admin/shop/tax/rate',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Tax Rate',
                                        'action' => 'add',
                                        'route' => 'admin/shop/tax/rate/edit',
                                        'resource' => 'menu:admin'
                                    ]
                                ]
                            ],
                            'codes' => [
                                'label' => 'Codes',
                                'action' => 'index',
                                'route' => 'admin/shop/tax/code',
                                'resource' => 'menu:admin',
                                'pages' => [
                                    'edit' => [
                                        'label' => 'List All Tax Codes',
                                        'action' => 'index',
                                        'route' => 'admin/shop/tax/code',
                                        'resource' => 'menu:admin'
                                    ],
                                    'add' => [
                                        'label' => 'Add New Tax Code',
                                        'action' => 'add',
                                        'route' => 'admin/shop/tax/code/edit',
                                        'resource' => 'menu:admin'
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'advert' => [
                        'label' => 'Adverts',
                        'action' => 'index',
                        'route' => 'admin/shop/advert',
                        'resource' => 'menu:admin',
                        'pages' => [
                            'list' => [
                                'label' => 'List All Adverts',
                                'action' => 'index',
                                'route' => 'admin/shop/advert',
                                'resource' => 'menu:admin'
                            ],
                            'add' => [
                                'label' => 'Add New Advert',
                                'action' => 'add',
                                'route' => 'admin/shop/advert/edit',
                                'resource' => 'menu:admin'
                            ]
                        ]
                    ],
                    'shop-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/shop/settings',
                        'resource' => 'menu:admin',
                    ],
                ],
                'route' => 'admin/shop',
                'resource' => 'menu:admin'
            ],
        ],
    ],
];
