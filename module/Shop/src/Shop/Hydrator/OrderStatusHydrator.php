<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Status
 *
 * @package Shop\Hydrator
 */
class OrderStatusHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\OrderStatusModel $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'orderStatusId'    => $object->getOrderStatusId(),
            'orderStatus'      => $object->getOrderStatus(),
        ];
    }
}
