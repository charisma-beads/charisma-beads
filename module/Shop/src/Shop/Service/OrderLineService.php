<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Hydrator\OrderLineHydrator;
use Shop\Mapper\OrderLineMapper;
use Shop\Model\CartModel;
use Shop\Model\Order\Line;
use Shop\Model\OrderLineInterface;
use Shop\Model\OrderLineModel;
use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Line
 *
 * @package Shop\Service
 */
class OrderLineService extends AbstractMapperService
{
    protected $hydrator     = OrderLineHydrator::class;
    protected $mapper       = OrderLineMapper::class;
    protected $model        = Line::class;
    
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
        /* @var $mapper OrderLineMapper */
        $mapper = $this->getMapper();
        $orderLines = $mapper->getOrderLinesByOrderId($orderId);
        
        return $orderLines;
    }

    /**
     * @param OrderLineInterface $lineModel
     * @param $orderId
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function addLine(OrderLineInterface $lineModel, $orderId)
    {
        /* @var $cart CartService */
        $cart = $this->getService(CartService::class);
        $priceTax = $cart->calculateTax($lineModel);

        $lineData = [
            'orderId'   => $orderId,
            'quantity'  => $lineModel->getQuantity(),
            'price'     => $priceTax['price'],
            'tax'       => $priceTax['tax'],
            'metadata'  => $lineModel->getMetadata(),
        ];

        $lineModel = $this->getMapper()->getModel($lineData);

        return $this->save($lineModel);
    }

    /**
     * @param CartModel|OrderLineModel $lines
     * @param $orderId
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function processLines($lines, $orderId)
    {
        foreach($lines as $item) {
            $this->addLine($item, $orderId);
        }
    }
}
