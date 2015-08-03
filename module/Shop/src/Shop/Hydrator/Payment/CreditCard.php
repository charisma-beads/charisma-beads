<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Payment
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Payment;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;

/**
 * Class CreditCard
 *
 * @package Shop\Hydrator\Payment
 */
class CreditCard extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('date', new DateTimeStrategy());
    }

    /**
     * @param \Shop\Model\Payment\CreditCard $object
     * @return array
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
