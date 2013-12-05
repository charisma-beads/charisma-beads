<?php
namespace Shop\Hydrator\Tax;

use Application\Hydrator\AbstractHydrator;

class Code extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Tax\Code $object
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
