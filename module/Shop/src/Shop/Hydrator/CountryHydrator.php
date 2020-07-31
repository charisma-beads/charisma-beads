<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Country
 *
 * @package Shop\Hydrator
 */
class CountryHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\CountryModel $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
            'countryId'     => $object->getCountryId(),
            'postZoneId'    => $object->getPostZoneId(),
            'country'       => $object->getCountry(),
            'code'          => $object->getCode(),
        ];
    }
}
