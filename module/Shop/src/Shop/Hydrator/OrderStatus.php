<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class OrderStatus extends AbstractHydrator
{
    /**
     * @param \Shop\Model\OrderStatus $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'orderStatusId'    => $object->getOrderStatusId(),
            'status'           => $object->getStatus(),
        );
    }
}
