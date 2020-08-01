<?php

namespace Shop\Form;

use Laminas\Form\Element\Hidden;
use Laminas\Form\Form;

/**
 * Class Address
 *
 * @package Shop\Form
 */
class CustomerAddressForm extends Form
{	
    use CustomerAddressTrait;

    public function init()
    {
        $this->add([
            'name'  => 'customerAddressId',
            'type'  => Hidden::class,
        ]);
        
        $this->add([
        	'name'  => 'customerId',
        	'type'  => Hidden::class,
        ]);

        $this->add([
            'name' => 'returnTo',
            'type' => Hidden::class,
        ]);
        
        $this->addElements();
    }
}
