<?php
namespace Shop\Form\Settings;

use Zend\Form\Form;

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
            'type' => 'ShopCheckoutFieldSet',
            'name' => 'checkout_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Checkout Options',
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
