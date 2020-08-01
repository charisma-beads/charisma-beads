<?php

namespace Shop\Hydrator;

use Shop\Hydrator\Strategy\CreditCardNumberStrategy;
use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime;

/**
 * Class CreditCard
 *
 * @package Shop\Hydrator
 */
class CreditCardHydrator extends AbstractHydrator
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
     * @param \Shop\Model\CreditCardModel $object
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
