<?php
namespace Shop\Hydrator\Customer;

use Application\Hydrator\AbstractHydrator;

class DeliveryAddress extends AbstractHydrator
{

	/**
	 *
	 * @param \Shop\Model\Customer\DeliveryAddress $object        	
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'customerDeliveryAddressId'  => $object->getCustomerDeliveryAddressId(),
			'customerAddressId'          => $object->getCustomerAddressId()
		);
	}
}
