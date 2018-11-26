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
