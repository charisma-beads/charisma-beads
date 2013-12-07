<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;

class Customer extends AbstractHydrator
{
    public Function __construct()
    {
    	parent::__construct();
    
    	$dateTime = new DateTimeStrategy();
    
    	$this->addStrategy('dateCreated', $dateTime);
    	$this->addStrategy('dateModified', $dateTime);
    }
    
    /**
     *
     * @param \Shop\Model\Customer $object
     * @return array $data
     */
    public function extract($object)
    {
    	return array(
    		'customerId'         => $object->getCustomerId(),
    		'userId'             => $object->getUserId(),
    	    'prefixId'           => $object->getPrefixId(),
    		'firstname'          => $object->getFristName(),
    	    'lastname'           => $object->getLastName(),
    	    'billingAddressId'   => $object->getBillingAddressId(),
    	    'diliveryAddressId'  => $object->getDeliveryAddressId(),
    		'dateCreated'        => $this->extractValue('dateCreated', $object->getDateCreated()),
    		'dateModified'       => $this->extractValue('dateModified', $object->getDateModified())
    	);
    }
}
