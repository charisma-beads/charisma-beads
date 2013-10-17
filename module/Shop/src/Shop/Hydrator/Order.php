<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;

class Order extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('orderDate', new DateTimeStrategy());
    }
    
    /**
     *
     * @param \Shop\Model\Order $object            
     * @return array $data
     */
    public function extract($object)
    {
        return array(
            'orderId'       => $object->getOrderId(),
            'userId'        => $object->getUserId(),
            'orderStatusId' => $object->getOrderStatusId(),
            'txnId'         => $object->getTxnId(),
            'total'         => $object->getTotal(),
            'orderDate'     => $this->extractValue('orderDate', $object->getOrderDate()),
            'shipping'      => $object->getShipping(),
            'vatTotal'      => $object->getVatTotal(),
        );
    }
}
