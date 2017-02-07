<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Settings;

use Zend\Form\Form;

/**
 * Class Settings
 *
 * @package Shop\Form\Settings
 */
class Settings extends Form
{
    public function init()
    {
        $this->setAttribute('id','shop-settings');

        $this->add([
            'type' => 'ShopFieldSet',
            'name' => 'shop_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'General Options',
            ],
        ]);

        $this->add([
            'type' => 'ShopOrderFieldSet',
            'name' => 'order_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Order Options',
            ],
        ]);
        
        $this->add([
            'type' => 'ShopCartFieldSet',
            'name' => 'cart_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Cart Options',
            ],
        ]);
        
        $this->add([
            'type' => 'ShopCartCookieFieldSet',
            'name' => 'cart_cookie',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Cart Cookie Options',
            ],
        ]);

        $this->add([
            'type' => 'ShopPaypalFieldSet',
            'name' => 'paypal_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'PayPal Options',
            ],
        ]);

        $this->add([
            'type' => 'ShopInvoiceFieldSet',
            'name' => 'invoice_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Invoice Options',
            ],
        ]);

        $this->add([
            'type' => 'ShopReportsFieldSet',
            'name' => 'report_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Reports Options',
            ],
        ]);

        $this->add([
            'type' => 'NewProductsCarouselFieldSet',
            'name' => 'new_products_carousel',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'New Products Carousel Options',
            ],
        ]);
    }
}
