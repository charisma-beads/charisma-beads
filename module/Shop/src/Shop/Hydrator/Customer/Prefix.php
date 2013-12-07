<?php
namespace Shop\Hydrator\Customer;

use Application\Hydrator\AbstractHydrator;

class Address extends AbstractHydrator
{
	/**
	 *
	 * @param \Shop\Model\Customer\Prefix $object        	
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'prefixId'   => $object->getPrefixId(),
		    'prefix'     => $object->getPrefix()
		);
	}
}
