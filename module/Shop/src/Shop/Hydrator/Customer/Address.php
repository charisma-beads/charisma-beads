<?php
namespace Shop\Hydrator\Customer;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;

class Address extends AbstractHydrator
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
	 * @param \Shop\Model\Customer\Address $object        	
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'customerAddressId'  => $object->getCustomerAddressId(),
		    'customerId'         => $object->getCustomerId(),
		    'countryId'          => $object->getCountryId(),
			'address1'           => $object->getAddress1(),
			'address2'           => $object->getAddress2(),
			'address3'           => $object->getAddress3(),
			'city'               => $object->getCity(),
			'county'             => $object->getCounty(),
			'postcode'           => $object->getPostcode(),
			'phone'              => $object->getPhone(),
			'dateCreated'        => $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'       => $this->extractValue('dateModified', $object->getDateModified())
		);
	}
}
