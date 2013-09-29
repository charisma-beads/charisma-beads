<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Shop\Model\TaxRate;

class TaxRate extends AbstractHydrator
{
	public function extract(TaxRate $object)
	{
		return array(
			'taxRateId'	=> $object->getTaxRateId(),
			'taxRate'	=>$object->getTaxRate()
		);
	}
}
