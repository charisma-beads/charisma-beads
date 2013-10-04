<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class TaxRate extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\TaxRate $object
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
