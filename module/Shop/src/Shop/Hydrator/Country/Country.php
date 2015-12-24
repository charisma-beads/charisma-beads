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
 * Class Country
 *
 * @package Shop\Hydrator\Country
 */
class Country extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Country\Country $object
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
