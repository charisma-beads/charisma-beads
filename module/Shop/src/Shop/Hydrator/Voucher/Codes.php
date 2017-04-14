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

use Shop\Hydrator\Strategy\VoucherCategoriesStrategy;
use Shop\Hydrator\Strategy\VoucherZonesStrategy;
use Shop\Model\Voucher\Code;
use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

/**
 * Class Codes
 *
 * @package Shop\Hydrator\Voucher
 */
class Codes extends AbstractHydrator
{

    public function __construct()
    {
        $dateStrategy = new DateTime([
            'extractFormat' => 'Y-m-d',
            'hydrateFormat' => 'Y-m-d',
        ]);
        $this->addStrategy('active', new TrueFalse());
        $this->addStrategy('startDate', $dateStrategy);
        $this->addStrategy('endDate', $dateStrategy);
        $this->addStrategy('productCategories', new VoucherCategoriesStrategy());
        $this->addStrategy('zones', new VoucherZonesStrategy());
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
            'productCategories' => $this->extractValue('productCategories', $object->getProductCategories()),
            'zones'             => $this->extractValue('zones', $object->getZones()),
        ];
    }
}