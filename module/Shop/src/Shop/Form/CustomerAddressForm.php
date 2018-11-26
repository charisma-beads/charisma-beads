<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use Zend\Form\Element\Hidden;
use Zend\Form\Form;

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
