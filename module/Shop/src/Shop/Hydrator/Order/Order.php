<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Order;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\NullStrategy;
use UthandoCommon\Hydrator\Strategy\Serialize;

/**
 * Class Order
 *
 * @package Shop\Hydrator\Order
 */
class Order extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('orderDate', new DateTimeStrategy());
        $this->addStrategy('metadata', new Serialize());
        $this->addStrategy('orderNumber', new NullStrategy());
    }
    
    /**
     *
     * @param \Shop\Model\Order\Order $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
            'orderId'       => $object->getOrderId(),
            'customerId'    => $object->getCustomerId(),
            'orderStatusId' => $object->getOrderStatusId(),
            'orderNumber'   => $this->extractValue('orderNumber', $object->getOrderNumber(false)),
            'total'         => $object->getTotal(),
            'orderDate'     => $this->extractValue('orderDate', $object->getOrderDate()),
            'shipping'      => $object->getShipping(),
            'taxTotal'      => $object->getTaxTotal(),
            'shippingTax'   => $object->getShippingTax(),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        ];
    }
}
