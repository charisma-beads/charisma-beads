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
	            //'column-size' => 'md-4',
                'label' => 'Billing Address:',
	            //'label_attributes' => [
	                //'class' => 'col-md-2 control-label',
	            //],
	       ],
	    ]);
	    
	    $this->add([
            'name' => 'deliveryAddressId',
            'type' => 'CustomerAddressList',
            'options' => [
                //'column-size' => 'md-4',
                'label' => 'Delivery Address:',
                //'label_attributes' => [
                    //'class' => 'col-md-2 control-label',
                //],
            ],
        ]);
	    
	    $this->addElements();
	}
}
