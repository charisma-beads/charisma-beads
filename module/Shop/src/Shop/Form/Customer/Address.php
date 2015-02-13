<?php
namespace Shop\Form\Customer;

use Zend\Form\Form;

class Address extends Form
{	
    use AddressTrait;
    
    public function init()
    {
        $this->add([
            'name'  => 'customerAddressId',
            'type'  => 'hidden',
        ]);
        
        $this->add([
        	'name'  => 'customerId',
        	'type'  => 'hidden',
        ]);
        
        $this->add([
        	'name' => 'dateCreated',
        	'type' => 'hidden',
        ]);
        
        $this->add([
        	'name' => 'dateModified',
        	'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'returnTo',
            'type' => 'hidden',
        ]);
        
        $this->addElements();
    }
}
