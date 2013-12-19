<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class Country extends AbstractHydrator
{
    protected $hydratorMap = array(
    	'Shop\Hydrator\Post\Zone'    => 'Shop\Model\Post\Zone',
    );
    
    protected $prefix = 'country.';
    
    public function __construct($useRelationships)
    {
        parent::__construct();
        $this->useRelationships = $useRelationships;
    }
    
    /**
     *
     * @param \Shop\Model\Country $object            
     * @return array $data
     */
    public function extract ($object)
    {
        return array(
            'countryId'     => $object->getCountryId(),
            'postZoneId'    => $object->getPostZoneId(),
            'country'       => $object->getCountry()
        );
    }
}
