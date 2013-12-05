<?php
namespace Shop\Hydrator\Customer;

use Application\Hydrator\AbstractHydrator;

class BillingAddress extends AbstractHydrator
{

	/**
	 *
	 * @param \Shop\Model\Customer\BillingAddress $object        	
	 * @return array $data
	 */
	public function extract ($object)
	{
		return array(
			'customerBillingAddressId'   => $object->getCustomerBillingAddressId(),
			'customerAddressId'          => $object->getCustomerAddressId()
		);
	}
}
