<?php

namespace Shop\Form\Customer;

use Zend\Form\Form;

class Customer extends Form
{	
    use CustomerTrait;
    
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
            'name'      => 'redirectToEdit',
            'type'      => 'hidden',
            'attributes'   => [
                'value' => true,
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
	    
	    $this->addElements();
	}
}
