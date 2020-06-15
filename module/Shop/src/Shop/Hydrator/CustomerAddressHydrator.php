<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;

/**
 * Class Address
 *
 * @package Shop\Hydrator
 */
class CustomerAddressHydrator extends AbstractHydrator
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
	 * @param \Shop\Model\CustomerAddressModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'customerAddressId'  => $object->getCustomerAddressId(),
		    'customerId'         => $object->getCustomerId(),
		    'countryId'          => $object->getCountryId(),
		    'provinceId'         => $object->getProvinceId(),
			'address1'           => $object->getAddress1(),
			'address2'           => $object->getAddress2(),
			'address3'           => $object->getAddress3(),
			'city'               => $object->getCity(),
			'county'             => $object->getCounty(),
			'postcode'           => $object->getPostcode(),
			'phone'              => $object->getPhone(),
			'email'              => $object->getEmail(),
			'dateCreated'        => $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'       => $this->extractValue('dateModified', $object->getDateModified())
		];
	}
}
