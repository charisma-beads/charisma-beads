<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Customer;

use Zend\Form\Form;

/**
 * Class Address
 *
 * @package Shop\Form\Customer
 */
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
