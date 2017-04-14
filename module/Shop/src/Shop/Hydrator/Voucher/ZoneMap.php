<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Hydrator\Voucher;

use Shop\Model\Voucher\ZoneMap as ZoneMapModel;
use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class ZoneMap
 *
 * @package Shop\Hydrator\Voucher
 */
class ZoneMap extends AbstractHydrator
{
    /**
     * @param ZoneMapModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'voucherId' => $object->getVoucherId(),
            'zoneId'    => $object->getZoneId(),
        ];
    }
}