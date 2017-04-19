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
use Shop\Hydrator\Strategy\VoucherExpiryStrategy;
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
        $this->addStrategy('limitCustomer', new TrueFalse());
        $this->addStrategy('active', new TrueFalse());
        $this->addStrategy('startDate', new DateTime([
            'extractFormat' => 'Y-m-d',
            'hydrateFormat' => 'Y-m-d',
        ]));
        $this->addStrategy('expiry', new VoucherExpiryStrategy([
            'extractFormat' => 'Y-m-d',
            'hydrateFormat' => 'Y-m-d',
        ]));
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
            'redeemable'        => $object->getRedeemable(),
            'quantity'          => $object->getQuantity(),
            'limitCustomer'     => $this->extractValue('limitCustomer', $object->isLimitCustomer()),
            'noPerCustomer'     => $object->getNoPerCustomer(),
            'minCartCost'       => $object->getMinCartCost(),
            'discountOperation' => $object->getDiscountOperation(),
            'startDate'         => $this->extractValue('startDate', $object->getStartDate()),
            'expiry'            => $this->extractValue('expiry', $object->getExpiry()),
            'productCategories' => $this->extractValue('productCategories', $object->getProductCategories()),
            'zones'             => $this->extractValue('zones', $object->getZones()),
        ];
    }
}