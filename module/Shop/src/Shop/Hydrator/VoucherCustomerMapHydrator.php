<?php

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