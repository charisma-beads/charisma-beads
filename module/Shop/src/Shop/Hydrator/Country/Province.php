<?php
namespace Shop\Hydrator\Country;

use UthandoCommon\Hydrator\AbstractHydrator;

class Province extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Country\Province $object
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
            'lft'                       => $object->getLft(),
            'rgt'                       => $object->getRgt(),
        ];
    }
}
