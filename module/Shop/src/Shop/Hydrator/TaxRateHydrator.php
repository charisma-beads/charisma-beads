<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Shop\Hydrator\Strategy\PercentStrategy;

/**
 * Class Rate
 *
 * @package Shop\Hydrator
 */
class TaxRateHydrator extends AbstractHydrator
{
    public Function __construct()
    {
    	parent::__construct();
    
    	$this->addStrategy('taxRate', new PercentStrategy());
    }
    
	/**
	 * @param \Shop\Model\TaxRateModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'taxRateId'	=> $object->getTaxRateId(),
			'taxRate'	=> $this->extractValue('taxRate', $object->getTaxRate()),
        ];
	}
}
