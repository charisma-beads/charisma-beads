<?php
namespace Shop\Hydrator\Order;

use Application\Hydrator\AbstractHydrator;

class Line extends AbstractHydrator
{
    protected $prefix = 'orderLine.';
    
    /**
     *
     * @param \Shop\Model\Order\Line $object            
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
