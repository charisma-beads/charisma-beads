<?php

namespace Shop\Form\Customer;

use Zend\Form\Form;

class Customer extends Form
{	
	public function init()
	{
	    $this->add([
	        'name' => 'customerId',
	        'type' => 'hidden',
	    ]);
	    
	    $this->add([
            'name' => 'userId',
	        'type' => 'hidden',
	    ]);
	    
	    $this->add([
            'name' => 'prefixId',
	        'type' => 'CustomerPrefixList',
	        'attributes'	=> [
	           'autofocus'		=> true,
	        ],
	        'options'		=> [
	           'label'		=> 'Prefix:',
	           'required'	=> true,
	        ],
	    ]);
	    
	    $this->add([
            'name' => 'firstname',
	        'type' => 'text',
	        'attributes'	=> [
	           'readonly' => true,
	        ],
	        'options'		=> [
	           'label' => 'Firstname:'
	        ],
	    ]);
	    
	    $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'attributes'	=> [
                'readonly' => true,
            ],
            'options'		=> [
                'label' => 'Lastname:'
            ],
        ]);
	    
	    $this->add([
	        'name' => 'billingAddressId',
	        'type' => 'CustomerAddressList',
	        'options' => [
                'label' => 'Billing Address:',
	       ],
	    ]);
	    
	    $this->add([
            'name' => 'deliveryAddressId',
            'type' => 'CustomerAddressList',
            'options' => [
                'label' => 'Delivery Address:',
            ],
        ]);
	    
	    $this->add([
            'name' => 'email',
            'type' => 'email',
	        'attributes'	=> [
	           'readonly' => true,
	        ],
            'options' => [
                'label' => 'Email:',
            ],
        ]);
	}
}
