<?php

return [
    'template_map' => [
        'application/index/index'                               => __DIR__ . '/view/application/index/index.phtml',

        'error/404'                                             => __DIR__ . '/view/error/404.phtml',
        'error/index'                                           => __DIR__ . '/view/error/index.phtml',

        'layout/layout'                                         => __DIR__ . '/view/layout/layout.phtml',
        'layout/page-title'                                     => __DIR__ . '/view/layout/page-title.phtml',

        'partial/sky-form'                                      => __DIR__ . '/view/partial/sky-form.phtml',

        'shop/cart/summary'                                     => __DIR__ . '/view/shop/cart/summary.phtml',
        'shop/cart/view'                                        => __DIR__ . '/view/shop/cart/view.phtml',
        'shop/catalog/index'                                    => __DIR__ . '/view/shop/catalog/index.phtml',
        'shop/catalog/search'                                   => __DIR__ . '/view/shop/catalog/search.phtml',
        'shop/catalog/view'                                     => __DIR__ . '/view/shop/catalog/view.phtml',
        'shop/checkout/confirm-address'                         => __DIR__ . '/view/shop/checkout/confirm-address.phtml',
        'shop/checkout/confirm-order'                           => __DIR__ . '/view/shop/checkout/confirm-order.phtml',
        'shop/checkout/customer-details'                        => __DIR__ . '/view/shop/checkout/customer-details.phtml',
        'shop/checkout/index'                                   => __DIR__ . '/view/shop/checkout/index.phtml',
        'shop/customer/my-details'                              => __DIR__ . '/view/shop/customer/my-details.phtml',
        'shop/customer-address/add-address'                     => __DIR__ . '/view/shop/customer-address/add-address.phtml',
        'shop/customer-address/edit-address'                    => __DIR__ . '/view/shop/customer-address/edit-address.phtml',
        'shop/customer-address/my-addresses'                    => __DIR__ . '/view/shop/customer-address/my-addresses.phtml',
        'shop/faq/faq'                                          => __DIR__ . '/view/shop/faq/faq.phtml',
        'shop/payment/credit-card'                              => __DIR__ . '/view/shop/payment/credit-card.phtml',
        'shop/payment/phone'                                    => __DIR__ . '/view/shop/payment/phone.phtml',
        'shop/paypal/success'                                   => __DIR__ . '/view/shop/order/view.phtml',
        'shop/order/my-orders'                                  => __DIR__ . '/view/shop/order/my-orders.phtml',
        'shop/order/pagination'                                 => __DIR__ . '/view/shop/order/pagination.phtml',
        'shop/order/view'                                       => __DIR__ . '/view/shop/order/view.phtml',
        'shop/shop/shop-front'                                  => __DIR__ . '/view/shop/shop/shop-front.phtml',
        'shop/product-nav'                                      => __DIR__ . '/view/shop/product-nav.phtml',
        'shop/options'                                          => __DIR__ . '/view/shop/options.phtml',
        'shop/parallax'                                         => __DIR__ . '/view/shop/parallax.phtml',

        'uthando-article/article/404'                           => __DIR__ . '/view/uthando-article/article/404.phtml',
        'uthando-article/article/view'                          => __DIR__ . '/view/uthando-article/article/view.phtml',

        'uthando-contact/contact/index'                         => __DIR__ . '/view/uthando-contact/contact/index.phtml',
        'uthando-contact/contact/thank-you'                     => __DIR__ . '/view/uthando-contact/contact/thank-you.phtml',
        'uthando-contact/email-template/default-content'        => __DIR__ . '/view/uthando-contact/email-template/default-content.phtml',
        'uthando-contact/email-template/default-layout'         => __DIR__ . '/view/uthando-contact/email-template/default-layout.phtml',
        'uthando-contact/email-template/default-sender-copy'    => __DIR__ . '/view/uthando-contact/email-template/default-sender-copy.phtml',

        'uthando-events/time-line/index'                        => __DIR__ . '/view/uthando-events/time-line/index.phtml',

        'uthando-navigation/main-menu'                          => __DIR__ . '/view/uthando-navigation/main-menu.phtml',
        'uthando-navigation/top-menu'                           => __DIR__ . '/view/uthando-navigation/top-menu.phtml',
        'uthando-navigation/user-menu'                          => __DIR__ . '/view/uthando-navigation/user-menu.phtml',

        'uthando-news/news/news-item'                           => __DIR__ . '/view/uthando-news/news/news-item.phtml',
        'uthando-news/news/paginate'                            => __DIR__ . '/view/uthando-news/news/paginate.phtml',
        'uthando-news/news/view'                                => __DIR__ . '/view/uthando-news/news/view.phtml',

        'uthando-newsletter/subscriber/update-subscription'     => __DIR__ . '/view/uthando-newsletter/subscriber/update-subscription.phtml',

        'uthando-testimonial/testimonial/view'                  => __DIR__ . '/view/uthando-testimonial/testimonial/view.phtml',

        'uthando-twitter/twitter/twitter-feed'                  => __DIR__ . '/view/uthando-twitter/twitter/twitter-feed.phtml',

        'uthando-user/user/forgot-password'                     => __DIR__ . '/view/uthando-user/user/forgot-password.phtml',
        'uthando-user/user/login'                               => __DIR__ . '/view/uthando-user/user/login.phtml',
        'uthando-user/user/password'                            => __DIR__ . '/view/uthando-user/user/password.phtml',
        'uthando-user/user/register'                            => __DIR__ . '/view/uthando-user/user/login.phtml',
    ],
];