<?php

namespace Shop;

return [
    'user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Controller\CartController::class => ['action' => 'all'],
                                Controller\CatalogController::class => ['action' => 'all'],
                                Controller\CheckoutController::class => ['action' => ['index']],
                                Controller\FaqController::class => ['action' => ['faq']],
                                Controller\ProductController::class=> ['action' => [ 'view']],
                                Controller\ShopController::class => ['action' => ['shop-front']],
                                Controller\VoucherCodesController::class => ['action' => ['add-voucher']],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Controller\CheckoutController::class => ['action' => 'all'],
                                Controller\CountryProvinceController::class => ['action' => ['country-province-list']],
                                Controller\CustomerController::class => ['action' => ['my-details']],
                                Controller\CustomerAddressController::class => ['action' => ['my-addresses', 'edit-address', 'add-address', 'delete-address']],
                                Controller\OrderController::class => ['action' => ['cancel', 'my-orders', 'print', 'view']],
                                Controller\PaymentController::class => ['action' => 'all'],
                                Controller\PaypalController::class => ['action' => ['process', 'success', 'cancel']],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                Controller\AdvertController::class => ['action' => 'all'],
                                Controller\CountryController::class => ['action' => 'all'],
                                Controller\CountryProvinceController::class => ['action' => 'all'],
                                Controller\CustomerController::class => ['action' => 'all'],
                                Controller\CustomerAddressController::class => ['action' => 'all'],
                                Controller\FaqController::class => ['action' => 'all'],
                                Controller\OrderController::class => ['action' => 'all'],
                                Controller\CreateOrderController::class => ['action' => 'all'],
                                Controller\PaypalController::class=> ['action' => ['search']],
                                Controller\PostCostController::class => ['action' => 'all'],
                                Controller\PostLevelController::class => ['action' => 'all'],
                                Controller\PostUnitController::class => ['action' => 'all'],
                                Controller\PostZoneController::class => ['action' => 'all'],
                                Controller\ProductController::class => ['action' => 'all'],
                                Controller\ProductCategoryController::class=> ['action' => 'all'],
                                Controller\ProductImageController::class => ['action' => 'all'],
                                Controller\ProductGroupController::class => ['action' => 'all'],
                                Controller\ProductOptionController::class => ['action' => 'all'],
                                Controller\ProductSizeController::class => ['action' => 'all'],
                                Controller\ShopController::class => ['action' => 'all'],
                                Controller\TaxCodeController::class => ['action' => 'all'],
                                Controller\TaxRateController::class => ['action' => 'all'],
                                Controller\ReportController::class => ['action' => 'all'],
                                Controller\SettingsController::class => ['action' => 'all'],
                                Controller\VoucherAdminController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                Controller\AdvertController::class,
                Controller\CartController::class,
                Controller\CatalogController::class,
                Controller\CheckoutController::class,
                Controller\CountryController::class,
                Controller\CountryProvinceController::class,
                Controller\CustomerController::class,
                Controller\CustomerAddressController::class,
                Controller\FaqController::class,
                Controller\OrderController::class,
                Controller\CreateOrderController::class,
                Controller\PaymentController::class,
                Controller\PaypalController::class,
                Controller\PostCostController::class,
                Controller\PostLevelController::class,
                Controller\PostUnitController::class,
                Controller\PostZoneController::class,
                Controller\ProductController::class,
                Controller\ProductCategoryController::class,
                Controller\ProductImageController::class,
                Controller\ProductGroupController::class,
                Controller\ProductOptionController::class,
                Controller\ProductSizeController::class,
                Controller\ShopController::class,
                Controller\TaxCodeController::class,
                Controller\TaxRateController::class,
                Controller\ReportController::class,
                Controller\SettingsController::class,
                Controller\VoucherAdminController::class,
                Controller\VoucherCodesController::class,
            ],
        ],
    ],
];