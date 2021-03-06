<?php

namespace Shop\Hydrator;

use Shop\Hydrator\Strategy\VoucherCategoriesStrategy;
use Shop\Hydrator\Strategy\VoucherExpiryStrategy;
use Shop\Hydrator\Strategy\VoucherZonesStrategy;
use Shop\Model\VoucherCodeModel;
use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime;
use Common\Hydrator\Strategy\TrueFalse;

/**
 * Class Codes
 *
 * @package Shop\Hydrator
 */
class VoucherCodeHydrator extends AbstractHydrator
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
     * @param VoucherCodeModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'voucherId'         => $object->getVoucherId(),
            'code'              => $object->getCode(),
            'description'       => $object->getDescription(),
            'active'            => $this->extractValue('active', $object->isActive()),
            'redeemable'        => $object->getRedeemable(),
            'quantity'          => $object->getQuantity(),
            'limitCustomer'     => $this->extractValue('limitCustomer', $object->isLimitCustomer()),
            'noPerCustomer'     => $object->getNoPerCustomer(),
            'minCartCost'       => $object->getMinCartCost(),
            'discountOperation' => $object->getDiscountOperation(),
            'discountAmount'    => $object->getDiscountAmount(),
            'startDate'         => $this->extractValue('startDate', $object->getStartDate()),
            'expiry'            => $this->extractValue('expiry', $object->getExpiry()),
            'productCategories' => $this->extractValue('productCategories', $object->getProductCategories()),
            'zones'             => $this->extractValue('zones', $object->getZones()),
        ];
    }
}