<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

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
