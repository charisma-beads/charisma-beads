<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Hydrator\Voucher;

use Shop\Model\Voucher\Code;
use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime;
use Zend\Hydrator\Strategy\BooleanStrategy;

/**
 * Class Codes
 *
 * @package Shop\Hydrator\Voucher
 */
class Codes extends AbstractHydrator
{

    public function __construct()
    {
        $dateStrategy = new DateTime();
        $this->addStrategy('active', new BooleanStrategy(1, 0));
        $this->addStrategy('startDate', $dateStrategy);
        $this->addStrategy('endDate', $dateStrategy);
    }

    /**
     * @param Code $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'voucherId'         => $object->getVoucherId(),
            'code'              => $object->getCode(),
            'active'            => $this->extractValue('active', $object->isActive()),
            'quantity'          => $object->getQuantity(),
            'minCartCost'       => $object->getMinCartCost(),
            'discountOperation' => $object->getDiscountOperation(),
            'startDate'         => $this->extractValue('startDate', $object->getStartDate()),
            'endDate'           => $this->extractValue('endDate', $object->getEndDate()),
        ];
    }
}