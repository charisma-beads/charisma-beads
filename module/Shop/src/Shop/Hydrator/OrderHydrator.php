<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\NullStrategy;
use Shop\Hydrator\Strategy\Serialize;

/**
 * Class Order
 *
 * @package Shop\Hydrator
 */
class OrderHydrator extends AbstractHydrator
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
     * @param \Shop\Model\OrderModel $object
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
            'discount'      => $object->getDiscount(),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        ];
    }
}
