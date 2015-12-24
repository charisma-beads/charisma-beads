<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Order;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Line
 *
 * @package Shop\Service\Order
 */
class Line extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopOrderLine';
    
    protected $tags = [
        'order-line',
    ];

    /**
     * @param int $orderId
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getOrderLinesByOrderId($orderId)
    {
        $orderId = (int) $orderId;
        /* @var $mapper \Shop\Mapper\Order\Line */
        $mapper = $this->getMapper();
        $orderLines = $mapper->getOrderLinesByOrderId($orderId);
        
        return $orderLines;
    }
}
