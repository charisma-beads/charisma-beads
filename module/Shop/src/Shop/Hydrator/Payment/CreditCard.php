<?php
namespace Shop\Hydrator\Payment;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;

class CreditCard extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('date', new DateTimeStrategy());
    }
    /**
     * @param \Shop\Model\Payment\CreditCard $object
     */
    public function extract($object)
    {
        return [
            'orderId'       => $object->getOrderId(),
            'total'         => $object->getTotal(),
            'ccType'        => $object->getCcType(),
            'ccName'        => $object->getCcName(),
            'ccNumber'      => $object->getCcNumber(),
            'cvv2'          => $object->getCvv2(),
            'ccEpiryDate'   => $object->getCcExpiryDate(),
            'ccStratDate'   => $object->getCcStartDate(),
            'address'       => $object->getAddress(),
        ];
    }
}
