<?php
namespace Shop\Form\Customer;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class CustomerDetails extends Form
{   
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods(false))
            ->setInputFilter(new InputFilter())
        ;
    }
    
    public function init()
    {
        $this->add([
            'type' => 'ShopCustomerFieldSet',
            'name' => 'customer',
            'options' => [
                'label' => 'Customer',
                'use_as_base_fieldset' => true,
                'billing_country' => $this->options['billing_country'],
                'delivery_country' => $this->options['delivery_country'],
            ],
        ]);
        
        $this->add([
            'type' => 'checkbox',
            'name' => 'shipToBilling',
            'options' => [
                'label'                 => 'Ship to billing address',
                'use_hidden_element'    => true,
                'checked_value'         => '1',
                'unchecked_value'       => '0',
            ], 
        ]);
    }
}
