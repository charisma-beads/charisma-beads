<?php
namespace Shop\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;

class Country extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Country $object            
     * @return array $data
     */
    public function extract ($object)
    {
        return array(
            'countryId'     => $object->getCountryId(),
            'postZoneId'    => $object->getPostZoneId(),
            'country'       => $object->getCountry(),
            'code'          => $object->getCode(),
        );
    }
}
