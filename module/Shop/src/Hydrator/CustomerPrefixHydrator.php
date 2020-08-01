<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Prefix
 *
 * @package Shop\Hydrator
 */
class CustomerPrefixHydrator extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\CustomerPrefixModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'prefixId'   => $object->getPrefixId(),
		    'prefix'     => $object->getPrefix()
        ];
	}
}
