<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Application\Hydrator\Strategy\Serialize;

class Order extends AbstractHydrator
{
    protected $hydratorMap = array(
    	'User\Hydrator\User'            => 'User\Model\User',
        'Shop\Hydrator\Order\Status'    => 'Shop\Model\Order\Status',
    );
    
    protected $prefix = 'order.';
    
    public function __construct($useRelationships)
    {
        parent::__construct();
        
        $this->useRelationships = $useRelationships;
        $this->addStrategy('orderDate', new DateTimeStrategy());
        $this->addStrategy('metadata', new Serialize());
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
            'customerId'    => $object->getCustomerId(),
            'orderStatusId' => $object->getOrderStatusId(),
            'orderNumber'   => $object->getOrderNumber(),
            'total'         => $object->getTotal(),
            'orderDate'     => $this->extractValue('orderDate', $object->getOrderDate()),
            'shipping'      => $object->getShipping(),
            'taxTotal'      => $object->getTaxTotal(),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        );
    }
}
