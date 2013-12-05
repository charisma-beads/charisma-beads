<?php
namespace Shop\Hydrator\Tax;

use Application\Hydrator\AbstractHydrator;

class Rate extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Tax\Rate $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'taxRateId'	=> $object->getTaxRateId(),
			'taxRate'	=>$object->getTaxRate()
		);
	}
}
