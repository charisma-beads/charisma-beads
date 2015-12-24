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

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

/**
 * Class Customer
 *
 * @package Shop\Form\Customer
 */
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
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
	       ],
	    ]);
	    
	    $this->add([
            'name' => 'deliveryAddressId',
            'type' => 'CustomerAddressList',
            'options' => [
                'label' => 'Delivery Address:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],

            ],
        ]);
	    
	    $this->addElements();
	}
}
