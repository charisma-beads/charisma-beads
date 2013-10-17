<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class Country extends AbstractHydrator
{
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
