<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Shop\Model\TaxCode;

class TaxCode extends AbstractHydrator
{
	public function extract(TaxCode $object)
	{
		return array(
			'taxCodeId'		=> $object->getTaxCodeId(),
			'taxRateId'		=> $object->getTaxRateId(),
			'taxCode'		=> $object->getTaxCode(),
			'description'	=> $object->getDescription()
		);
	}
}
