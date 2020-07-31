<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Code
 *
 * @package Shop\Hydrator
 */
class TaxCodeHydrator extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\TaxCodeModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'taxCodeId'		=> $object->getTaxCodeId(),
			'taxRateId'		=> $object->getTaxRateId(),
			'taxCode'		=> $object->getTaxCode(),
			'description'	=> $object->getDescription()
        ];
	}
}
