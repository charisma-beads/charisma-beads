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

use Shop\Hydrator\Strategy\CreditCardNumberStrategy;
use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime;

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

        $dateTimeStrategy = new DateTime([
            'hydrateFormat' => 'Y/m',
        ]);

        $this->addStrategy('ccNumber', new CreditCardNumberStrategy());
        $this->addStrategy('ccEpiryDate', $dateTimeStrategy);
        $this->addStrategy('ccStratDate', $dateTimeStrategy);
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
            'ccNumber'      => $this->extractValue('ccNumber', $object->getCcNumber()),
            'cvv2'          => $object->getCvv2(),
            'ccEpiryDate'   => $this->extractValue('ccEpiryDate', $object->getCcExpiryDate()),
            'ccStratDate'   => $this->extractValue('ccStratDate', $object->getCcStartDate()),
            'address'       => $object->getAddress(),
        ];
    }
}
