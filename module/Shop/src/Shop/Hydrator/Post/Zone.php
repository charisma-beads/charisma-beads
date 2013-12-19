<?php
namespace Shop\Hydrator\Zone;

use Application\Hydrator\AbstractHydrator;

class Zone extends AbstractHydrator
{
    protected $hydratorMap = array(
    	'Shop\Hydrator\Tax\Code' => 'Shop\Model\Tax\Code',
    );
    
    protected $prefix = 'postZone.';
    
    public function __construct($useRelationships)
    {
    	parent::__construct();
    	$this->useRelationships = $useRelationships;
    }
    
    /**
     * @param \Shop\Model\Post\Zone $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'postZoneId'   => $object->getPostZoneId(),
            'taxCodeId'    => $object->getTaxCodeId(),
            'zone'         => $object->getZone(),
        );
    }
}
