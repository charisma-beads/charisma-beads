<?php

namespace Shop\Service;

use Shop\Hydrator\OrderLineHydrator;
use Shop\Mapper\OrderLineMapper;
use Shop\Model\CartModel;
use Shop\Model\OrderLineInterface;
use Shop\Model\OrderLineModel;
use Common\Service\AbstractMapperService;

/**
 * Class Line
 *
 * @package Shop\Service
 */
class OrderLineService extends AbstractMapperService
{
    protected $hydrator     = OrderLineHydrator::class;
    protected $mapper       = OrderLineMapper::class;
    protected $model        = OrderLineModel::class;
    
    protected $tags = [
        'order-line',
    ];

    /**
     * @param int $orderId
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
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
     * @throws \Common\Service\ServiceException
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
     * @throws \Common\Service\ServiceException
     */
    public function processLines($lines, $orderId)
    {
        foreach($lines as $item) {
            $this->addLine($item, $orderId);
        }
    }
}
