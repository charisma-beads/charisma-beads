<?php
namespace Shop\Hydrator\Tax;

use Application\Hydrator\AbstractHydrator;

class Code extends AbstractHydrator
{
    protected $hydratorMap = array(
    	'Shop\Hydrator\Tax\Rate' => 'Shop\Model\Tax\Rate',
    );
    
    protected $prefix = 'taxCode.';
    
    public function __construct($useRelationships)
    {
        parent::__construct();
        $this->useRelationships = $useRelationships;
    }
    
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
