<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Shop\Hydrator\Strategy\Serialize;

/**
 * Class Line
 *
 * @package Shop\Hydrator
 */
class OrderLineHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('metadata', new Serialize());
    }
    
    /**
     *
     * @param \Shop\Model\OrderLineModel $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
            'orderLineId'   => $object->getOrderLineId(),
            'orderId'       => $object->getOrderId(),
            'quantity'      => $object->getQuantity(),
            'price'         => $object->getPrice(),
            'tax'           => $object->getTax(),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        ];
    }
}
