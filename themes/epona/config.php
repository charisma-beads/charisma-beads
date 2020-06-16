<?php

return [
    'template_map' => [
        'application/index/index'                       => __DIR__ . '/view/application/index/index.phtml',
        'application/partial/paginate'                  => __DIR__ . '/view/partial/paginate.phtml',

        'error/404'                                     => __DIR__ . '/view/error/404.phtml',
        'error/index'                                   => __DIR__ . '/view/error/index.phtml',

        'layout/layout'                                 => __DIR__ . '/view/layout/layout.phtml',
        'layout/maintenance'                            => __DIR__ . '/view/layout/maintenance.phtml',
        'layout/page-title'                             => __DIR__ . '/view/layout/page-title.phtml',

        'partial/sky-form'                              => __DIR__ . '/view/partial/sky-form.phtml',

        'shop/cart'                                     => __DIR__ . '/view/shop/cart/cart.phtml',
        'shop/cart/summary'                             => __DIR__ . '/view/shop/cart/summary.phtml',
        'shop/cart/view'                                => __DIR__ . '/view/shop/cart/view.phtml',
        'shop/catalog/index'                            => __DIR__ . '/view/shop/catalog/index.phtml',
        'shop/catalog/new-products-carousel'            => __DIR__ . '/view/shop/catalog/new-products-carousel.phtml',
        'shop/catalog/product-list'                     => __DIR__ . '/view/shop/catalog/product-list.phtml',
        'shop/catalog/search'                           => __DIR__ . '/view/shop/catalog/search.phtml',
        'shop/catalog/view'                             => __DIR__ . '/view/shop/catalog/view.phtml',
        'shop/checkout/cancel-checkout'                 => __DIR__ . '/view/shop/checkout/cancel-checkout.phtml',
        'shop/checkout/confirm-address'                 => __DIR__ . '/view/shop/checkout/confirm-address.phtml',
        'shop/checkout/confirm-order'                   => __DIR__ . '/view/shop/checkout/confirm-order.phtml',
        'shop/checkout/customer-details'                => __DIR__ . '/view/shop/checkout/customer-details.phtml',
        'shop/checkout/index'                           => __DIR__ . '/view/shop/checkout/index.phtml',
        'shop/customer/my-details'                      => __DIR__ . '/view/shop/customer/my-details.phtml',
        'shop/customer-address/add-address'             => __DIR__ . '/view/shop/customer-address/add-address.phtml',
        'shop/customer-address/edit-address'            => __DIR__ . '/view/shop/customer-address/edit-address.phtml',
        'shop/customer-address/my-addresses'            => __DIR__ . '/view/shop/customer-address/my-addresses.phtml',
        'shop/faq/faq'                                  => __DIR__ . '/view/shop/faq/faq.phtml',
        'shop/payment/credit-card'                      => __DIR__ . '/view/shop/payment/credit-card.phtml',
        'shop/payment/phone'                            => __DIR__ . '/view/shop/payment/phone.phtml',
        'shop/paypal/success'                           => __DIR__ . '/view/shop/order/view.phtml',
        'shop/order/my-orders'                          => __DIR__ . '/view/shop/order/my-orders.phtml',
        'shop/order/pagination'                         => __DIR__ . '/view/shop/order/pagination.phtml',
        'shop/order/view'                               => __DIR__ . '/view/shop/order/view.phtml',
        'shop/shop/shop-front'                          => __DIR__ . '/view/shop/shop/shop-front.phtml',
        'shop/product-nav'                              => __DIR__ . '/view/shop/product-nav.phtml',
        'shop/options'                                  => __DIR__ . '/view/shop/options.phtml',
        'shop/parallax'                                 => __DIR__ . '/view/shop/parallax.phtml',
        'shop/voucher-codes/add-voucher'                => __DIR__ . '/view/shop/voucher-codes/add-voucher.phtml',

        'article/article/404'                           => __DIR__ . '/view/article/article/404.phtml',
        'article/article/view'                          => __DIR__ . '/view/article/article/view.phtml',

        'contact/contact/index'                         => __DIR__ . '/view/contact/contact/index.phtml',
        'contact/contact/thank-you'                     => __DIR__ . '/view/contact/contact/thank-you.phtml',
        'contact/email-template/default-content'        => __DIR__ . '/view/contact/email-template/default-content.phtml',
        'contact/email-template/default-layout'         => __DIR__ . '/view/contact/email-template/default-layout.phtml',
        'contact/email-template/default-sender-copy'    => __DIR__ . '/view/contact/email-template/default-sender-copy.phtml',

        'events/time-line/index'                        => __DIR__ . '/view/events/time-line/index.phtml',

        'navigation/main-menu'                          => __DIR__ . '/view/navigation/main-menu.phtml',
        'navigation/top-menu'                           => __DIR__ . '/view/navigation/top-menu.phtml',
        'navigation/user-menu'                          => __DIR__ . '/view/navigation/user-menu.phtml',

        'news/news/404'                                 => __DIR__ . '/view/error/404.phtml',
        'news/news/news-item'                           => __DIR__ . '/view/news/news/news-item.phtml',
        'news/news/paginate'                            => __DIR__ . '/view/news/news/paginate.phtml',
        'news/news/view'                                => __DIR__ . '/view/news/news/view.phtml',

        'newsletter/subscriber/update-subscription'     => __DIR__ . '/view/newsletter/subscriber/update-subscription.phtml',

        'testimonial/testimonial/view'                  => __DIR__ . '/view/testimonial/testimonial/view.phtml',

        'user/email/verify'                             => __DIR__ . '/view/user/email/verify.phtml',
        'user/user/forgot-password'                     => __DIR__ . '/view/user/user/forgot-password.phtml',
        'user/user/login'                               => __DIR__ . '/view/user/user/login.phtml',
        'user/user/password'                            => __DIR__ . '/view/user/user/password.phtml',
        'user/user/register'                            => __DIR__ . '/view/user/user/login.phtml',
    ],
];