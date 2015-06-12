<?php
namespace Shop\Hydrator\Order;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\Null;
use UthandoCommon\Hydrator\Strategy\Serialize;

class Order extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('orderDate', new DateTimeStrategy());
        $this->addStrategy('metadata', new Serialize());
        $this->addStrategy('orderNumber', new Null());
    }
    
    /**
     *
     * @param \Shop\Model\Order\Order $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
            'orderId'       => $object->getOrderId(),
            'customerId'    => $object->getCustomerId(),
            'orderStatusId' => $object->getOrderStatusId(),
            'orderNumber'   => $this->extractValue('orderNumber', $object->getOrderNumber(false)),
            'total'         => $object->getTotal(),
            'orderDate'     => $this->extractValue('orderDate', $object->getOrderDate()),
            'shipping'      => $object->getShipping(),
            'taxTotal'      => $object->getTaxTotal(),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        );
    }
}
