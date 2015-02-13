<?php
namespace Shop\Form\Customer;

use Zend\Form\Form;

class CustomerDetails extends Form
{
    public function init()
    {
        $this->add([
            'type' => 'ShopCustomerFieldSet',
            'name' => 'customer',
            'options' => [
                'label' => 'Customer',
                'use_as_base_fieldset' => true,
            ],
        ]);
        
        $this->add([
            'type' => 'ShopAddressFieldSet',
            'name' => 'billingAddress',
            'options' => [
                'label' => 'Billing Address',
                'country' => $this->getOption('country'),
            ],
        ]);
        
        $this->add([
            'type' => 'ShopAddressFieldSet',
            'name' => 'deliveryAddress',
            'options' => [
                'label' => 'Delivery Address',
                'country' => $this->getOption('country'),
            ],
        ]);
        
        $this->add([
            'type' => 'checkbox',
            'name' => 'shipToBilling',
            'options' => [
                'label'                 => 'Ship to billing address',
                'use_hidden_element'    => true,
                'checked_value'         => 1,
                'unchecked_value'       => 0,
            ], 
        ]);
    }
}
