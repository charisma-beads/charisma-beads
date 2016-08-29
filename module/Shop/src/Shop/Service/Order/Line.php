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

use Shop\Model\Cart\Cart;
use Shop\Model\Order\Line as LineModel;
use Shop\Model\Order\LineInterface;
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
        /* @var $mapper LineModel */
        $mapper = $this->getMapper();
        $orderLines = $mapper->getOrderLinesByOrderId($orderId);
        
        return $orderLines;
    }

    /**
     * @param LineInterface $lineModel
     * @param $orderId
     * @return int
     */
    public function addLine(LineInterface $lineModel, $orderId)
    {
        $lineData = [
            'orderId'   => $orderId,
            'quantity'  => $lineModel->getQuantity(),
            'price'     => $lineModel->getPrice(),
            'tax'       => $lineModel->getTax(),
            'metadata'  => $lineModel->getMetadata(),
        ];

        return $this->save($lineData);
    }

    /**
     * @param Cart|LineModel $lines
     * @param $orderId
     */
    public function processLines($lines, $orderId)
    {
        foreach($lines as $item) {
            $this->addLine($item, $orderId);
        }
    }
}
