<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class CustomerDeliveryAddress extends AbstractHydrator
{

	/**
	 *
	 * @param \Shop\Model\CustomerDeliveryAddress $object        	
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
