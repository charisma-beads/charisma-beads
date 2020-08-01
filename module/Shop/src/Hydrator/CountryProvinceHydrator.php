<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Province
 *
 * @package Shop\Hydrator
 */
class CountryProvinceHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\CountryProvinceModel $object
     * @return array $data
     */
    public function extract ($object)
    {
        return [
            'provinceId'                => $object->getProvinceId(),
            'countryId'                 => $object->getCountryId(),
            'provinceCode'              => $object->getProvinceCode(),
            'provinceName'              => $object->getProvinceName(),
            'provinceAlternateNames'    => $object->getProvinceAlternateNames(),
        ];
    }
}
