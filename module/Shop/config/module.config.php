<?php
return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'css/uthando-admin.css' => [
                    'css/shop.css',
                    'css/typeaheadjs.css',
                ],
            ],
            'paths' => [
                'Shop' => __DIR__ . '/../public',
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
            'Shop\Controller\Order\CreateOrder'     => 'Shop\Controller\Order\CreateOrder',
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
            'Shop\Controller\Faq'                   => 'Shop\Controller\Faq',
            'Shop\Controller\Payment'               => 'Shop\Controller\Payment',
            'Shop\Controller\Paypal'                => 'Shop\Controller\Paypal',
            'Shop\Controller\Report'                => 'Shop\Controller\Report',
            'Shop\Controller\Settings'              => 'Shop\Controller\Settings',
            'Shop\Controller\Shop'                  => 'Shop\Controller\Shop',
            \Shop\Controller\Voucher\VoucherCodes::class    => \Shop\Controller\Voucher\VoucherCodes::class,
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
            'ShopFaq'               => 'Shop\Form\Faq',
            'ShopVoucherCode'       => \Shop\Form\Voucher\Code::class,

            'ShopPaypalCredentialPairsFieldSet' => 'Shop\Form\Settings\Paypal\CredentialPairsFieldSet',
            'ShopPaypalCredentialSetFieldSet'   => 'Shop\Form\Settings\Paypal\CredentialSetFieldSet',
            'ShopSettings'                      => 'Shop\Form\Settings\Settings',
            'ShopFieldSet'                      => 'Shop\Form\Settings\ShopFieldSet',
            'ShopCartFieldSet'                  => 'Shop\Form\Settings\CartFieldSet',
            'ShopPaypalFieldSet'                => 'Shop\Form\Settings\PaypalFieldSet',
            'ShopReportsFieldSet'               => 'Shop\Form\Settings\ReportsFieldSet',
            'ShopCartCookieFieldSet'            => 'Shop\Form\Settings\CartCookieFieldSet',
            'ShopInvoiceFieldSet'               => 'Shop\Form\Settings\InvoiceFieldSet',
            'ShopOrderFieldSet'                 => Shop\Form\Settings\OrderFieldSet::class,
            'ShopOrderMetadataFieldSet'         => Shop\Form\Order\MetadataFieldSet::class,
            'NewProductsCarouselFieldSet'       => 'Shop\Form\Settings\NewProductsCarouselFieldSet',

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
            'FaqList'                   => 'Shop\Form\Element\FaqList',
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
            'ShopProductMetaData'   => \Shop\Hydrator\Product\MetaData::class,
            'ShopProductOption'     => 'Shop\Hydrator\Product\Option',
            'ShopProductSize'       => 'Shop\Hydrator\Product\Size',
            'ShopTaxCode'           => 'Shop\Hydrator\Tax\Code',
            'ShopTaxRate'           => 'Shop\Hydrator\Tax\Rate',
            'ShopFaq'               => 'Shop\Hydrator\Faq',
            'ShopVoucherCode'       => Shop\Hydrator\Voucher\Codes::class,
            \Shop\Hydrator\Voucher\CategoryMap::class => \Shop\Model\Voucher\CategoryMap::class,
            \Shop\Hydrator\Voucher\ZoneMap::class => \Shop\Hydrator\Voucher\ZoneMap::class,
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
            'ShopFaq'               => 'Shop\InputFilter\Faq',
            'ShopVoucherCode'       => \Shop\InputFilter\Voucher\Code::class,
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'Shop\Service\Report'                       => 'Shop\Service\Report',
        ],
        'factories' => [
            'Shop\Options\CartCookie'                   => 'Shop\Service\Factory\CartCookieOptions',
            'Shop\Options\Cart'                         => 'Shop\Service\Factory\CartOptions',
            'Shop\Options\Invoice'                      => 'Shop\Service\Factory\InvoiceOptions',
            'Shop\Options\Order'                        => 'Shop\Service\Factory\OrderOptions',
            'Shop\Options\Paypal'                       => 'Shop\Service\Factory\PaypalOptions',
            'Shop\Options\Reports'                      => 'Shop\Service\Factory\ReportsOptions',
            'Shop\Options\Shop'                         => 'Shop\Service\Factory\ShopOptions',
            'Shop\Options\NewProductsCarouselOptions'   => 'Shop\Service\Factory\NewProductsCarouselOptions',

            'Shop\Service\Cart\Cookie'                  => 'Shop\Service\Factory\CartCookie',
            'Shop\Service\Shipping'                     => Shop\Service\Factory\Shipping::class,
            'Shop\Service\Tax'                          => Shop\Service\Factory\Tax::class,

            'ExceptionMailer\ErrorHandling'             => Shop\Exception\MailerFactory::class
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
            'ShopFaq'               => 'Shop\Mapper\Faq',
            'ShopVoucherCode'       => \Shop\Mapper\Voucher\Code::class,
            \Shop\Mapper\Voucher\CategoryMap::class => \Shop\Mapper\Voucher\CategoryMap::class,
            \Shop\Mapper\Voucher\ZoneMap::class => \Shop\Mapper\Voucher\ZoneMap::class,
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'ShopAdvert'            => 'Shop\Model\Advert\Advert',
            'ShopAdvertHit'         => 'Shop\Model\Advert\Hit',
            'ShopCart'              => Shop\Model\Cart\Cart::class,
            'ShopCartItem'          => 'Shop\Model\Cart\Item',
            'ShopCountry'           => 'Shop\Model\Country\Country',
            'ShopCountryProvince'   => 'Shop\Model\Country\Province',
            'ShopCustomer'          => 'Shop\Model\Customer\Customer',
            'ShopCustomerAddress'   => 'Shop\Model\Customer\Address',
            'ShopCustomerPrefix'    => 'Shop\Model\Customer\Prefix',
            'ShopOrder'             => Shop\Model\Order\Order::class,
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
            'ShopFaq'               => 'Shop\Model\Faq',
            'ShopVoucherCode'       => \Shop\Model\Voucher\Code::class,
            \Shop\Model\Voucher\ZoneMap::class => \Shop\Model\Voucher\ZoneMap::class,
            \Shop\Model\Voucher\CategoryMap::class => \Shop\Model\Voucher\CategoryMap::class,
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
            'ShopFaq'               => 'Shop\Service\Faq',
            'ShopVoucherCode'       => \Shop\Service\Voucher\Code::class,
        ],
    ],
    'validators' => [
        'invokables' => [
            'ShopPostCode'  => 'Shop\I18n\Validator\PostCode',
        ],
    ],
    'view_helpers' => [
        'invokables'    => [
            'ShopAlert'                 => 'Shop\View\Alert',
            'BreadCrumbs'               => 'Shop\View\Breadcrumb',
            'CartOption'                => 'Shop\View\CartOption',
            'Cart'                      => 'Shop\View\Cart',
            'Category'                  => 'Shop\View\Category',
            'CountrySelect'             => 'Shop\View\CountrySelect',
            'CustomerAddress'           => 'Shop\View\CustomerAddress',
            'MonthYearSelect'           => 'Shop\View\FormMonthSelect',
            'InvoiceOption'             => 'Shop\View\InvoiceOption',
            'NormaliseOrderNumber'      => 'Shop\View\NormaliseOrderNumber',
            'NewProductsCarouselOption' => 'Shop\View\NewProductsCarouselOption',
            'OrderStatus'               => 'Shop\View\OrderStatus',
            'PercentFormat'             => 'Shop\View\PercentFormat',
            'PriceFormat'               => 'Shop\View\PriceFormat',
            'ProductHelper'             => 'Shop\View\Product',
            'ProductCategoryImage'      => 'Shop\View\ProductCategoryImage',
            'ProductImage'              => 'Shop\View\ProductImage',
            'ProductOptions'            => 'Shop\View\ProductOptions',
            'ProductPrice'              => 'Shop\View\ProductPrice',
            'ProductSearch'             => 'Shop\View\ProductSearch',
            'ProductTableRowState'      => 'Shop\View\ProductTableRowState',
            'ShopOption'                => 'Shop\View\ShopOption',
            'StructuredData'            => 'Shop\View\StructuredData',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'mail/error'           => __DIR__ . '/../view/error/mail.phtml',
            'cart/summary'         => __DIR__ . '/../view/shop/cart/cart-summary.phtml',
            'shop/cart'            => __DIR__ . '/../view/shop/cart/cart.phtml',
            'shop/order/details'   => __DIR__ . '/../view/shop/order/order-details.phtml',
            'error/mail'           => __DIR__ . '/../view/error/mail.phtml', // Exception_Mailer
            'error/paypal'         => __DIR__ . '/../view/error/paypal-error.phtml', // Exception_Mailer
        ],
        'template_path_stack' => [
            'shop' => __DIR__ . '/../view'
        ],
    ],
];
