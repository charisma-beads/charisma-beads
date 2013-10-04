<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class TaxCode extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\TaxCode $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'taxCodeId'		=> $object->getTaxCodeId(),
			'taxRateId'		=> $object->getTaxRateId(),
			'taxCode'		=> $object->getTaxCode(),
			'description'	=> $object->getDescription()
		);
	}
}
