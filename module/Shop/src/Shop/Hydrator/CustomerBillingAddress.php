<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class CustomerBillingAddress extends AbstractHydrator
{

	/**
	 *
	 * @param \Shop\Model\CustomerBillingAddress $object        	
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
