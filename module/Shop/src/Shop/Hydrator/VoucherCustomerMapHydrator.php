<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Hydrator;

use Shop\Model\VoucherCustomerMapModel as CustomerMapModel;
use Common\Hydrator\AbstractHydrator;

/**
 * Class CustomerMap
 * @package Shop\Hydrator
 */
class VoucherCustomerMapHydrator extends AbstractHydrator
{
    /**
     * @param CustomerMapModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'id'                => $object->getId(),
            'voucherId'         => $object->getVoucherId(),
            'customerId'        => $object->getCustomerId(),
            'count'             => $object->getCount(),
        ];
    }
}