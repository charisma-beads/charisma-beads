<?php
namespace Shop\Service\Order;

use UthandoCommon\Service\AbstractMapperService;

class Line extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Order\Line';
    protected $form = 'Shop\Form\Order\Line';
    protected $inputFilter = 'Shop\InputFilter\Order\Line';

    protected $serviceAlias = 'ShopOrderLine';
    
    public function getOrderLinesByOrderId($orderId)
    {
        $orderId = (int) $orderId;
        $orderLines = $this->getMapper()->getOrderLinesByOrderId($orderId);
        return $orderLines;
    }
}
