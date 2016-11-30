<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Customer;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\NullStrategy;

/**
 * Class Customer
 *
 * @package Shop\Hydrator\Customer
 */
class Customer extends AbstractHydrator
{
    public Function __construct()
    {
    	parent::__construct();
    	
    	$dateTime = new DateTimeStrategy();
        $null = new NullStrategy();

        $this->addStrategy('userId', $null);
        $this->addStrategy('number', $null);
        $this->addStrategy('billingAddressId', $null);
        $this->addStrategy('deliveryAddressId', $null);

    	$this->addStrategy('dateCreated', $dateTime);
    	$this->addStrategy('dateModified', $dateTime);
    }
    
    /**
     *
     * @param \Shop\Model\Customer\Customer $object
     * @return array $data
     */
    public function extract($object)
    {
    	return [
    		'customerId'         => $object->getCustomerId(),
    		'userId'             => $this->extractValue('userId', $object->getUserId()),
    	    'prefixId'           => $object->getPrefixId(),
            'number'             => $this->extractValue('number',$object->getNumber()),
    		'firstname'          => $object->getFirstname(),
    	    'lastname'           => $object->getLastname(),
    	    'billingAddressId'   => $this->extractValue('billingAddressId', $object->getBillingAddressId()),
    	    'deliveryAddressId'  => $this->extractValue('deliveryAddressId', $object->getDeliveryAddressId()),
    	    'email'              => $object->getEmail(),
    		'dateCreated'        => $this->extractValue('dateCreated', $object->getDateCreated()),
    		'dateModified'       => $this->extractValue('dateModified', $object->getDateModified())
        ];
    }
}
