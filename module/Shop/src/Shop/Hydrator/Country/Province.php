<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Country;

use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Province
 *
 * @package Shop\Hydrator\Country
 */
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
        ];
    }
}
