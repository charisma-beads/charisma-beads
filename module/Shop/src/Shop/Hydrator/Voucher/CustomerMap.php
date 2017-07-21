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

use Shop\Model\Voucher\CustomerMap as CustomerMapModel;
use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class CustomerMap
 * @package Shop\Hydrator\Voucher
 */
class CustomerMap extends AbstractHydrator
{
    /**
     * @param CustomerMapModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'voucherId'         => $object->getVoucherId(),
            'customerId'        => $object->getCustomerId(),
            'count'             => $object->getCount(),
        ];
    }
}