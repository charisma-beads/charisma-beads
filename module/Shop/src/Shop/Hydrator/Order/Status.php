<?php
namespace Shop\Hydrator\Order;

use Application\Hydrator\AbstractHydrator;

class Status extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Order\Status $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'orderStatusId'    => $object->getOrderStatusId(),
            'orderStatus'      => $object->getOrderStatus(),
        );
    }
}
