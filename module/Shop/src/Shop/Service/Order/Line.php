<?php
namespace Shop\Service\Order;

use UthandoCommon\Service\AbstractService;

class Line extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Order\Line';
    protected $form = 'Shop\Form\Order\Line';
    protected $inputFilter = 'Shop\InputFilter\Order\Line';
    
    public function getOrderLinesByOrderId($orderId)
    {
        $orderId = (int) $orderId;
        $orderLines = $this->getMapper()->getOrderLinesByOrderId($orderId);
        return $orderLines;
    }
}
