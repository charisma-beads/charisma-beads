<?php
namespace Shop\Hydrator\Customer;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\Null as NullStrategy;

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
    	return array(
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
    	);
    }
}
