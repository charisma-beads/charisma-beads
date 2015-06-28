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
        $this->add([
            'type' => 'ShopFieldSet',
            'name' => 'shop_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Shop Options',
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
            'type' => 'ShopPaypalFieldSet',
            'name' => 'paypal_options',
            'attributes' => [
                'class' => 'col-md-6',
                'id' => 'paypal-field-set',
            ],
            'options' => [
                'label' => 'PayPal Options',
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
            'type' => 'ShopInvoiceFieldSet',
            'name' => 'invoice_options',
            'attributes' => [
                'class' => 'col-md-6',
                'id' => 'invoice-field-set',
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
            'name' => 'button-submit',
            'type' => 'button',
            'attributes' => [
                'type' => 'submit',
                'class' => 'btn-primary'
            ],
            'options' => [
                'label' => 'Save',
                'column-size' => 'md-10 col-md-offset-2'
            ],
        ]);
    }
}
