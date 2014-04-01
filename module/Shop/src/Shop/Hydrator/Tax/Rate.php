<?php
namespace Shop\Hydrator\Tax;

use Application\Hydrator\AbstractHydrator;
use Shop\Hydrator\Strategy\Percent;

class Rate extends AbstractHydrator
{
    public Function __construct()
    {
    	parent::__construct();
    
    	$this->addStrategy('taxRate', new Percent());
    }
    
	/**
	 * @param \Shop\Model\Tax\Rate $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'taxRateId'	=> $object->getTaxRateId(),
			'taxRate'	=> $this->extractValue('taxRate', $object->getTaxRate()),
		);
	}
}
