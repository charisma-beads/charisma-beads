<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;

class OrderLine extends AbstractHydrator
{

    /**
     *
     * @param \Shop\Model\OrderLine $object            
     * @return array $data
     */
    public function extract($object)
    {
        return array(
            'orderLineId'   => $object->getOrderLineId(),
            'orderId'       => $object->getOrderId(),
            'productId'     => $object->getProductId(),
            'qty'           => $object->getQty(),
            'price'         => $object->getPrice(),
            'vatPercent'    => $object->getVatPercent(),
        );
    }
}
