<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Model;

use DateTime;
use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Codes
 *
 * @package Shop\Model
 */
class VoucherCodeModel implements ModelInterface
{
    use Model;

    const DISCOUNT_SUBTOTAL             = '-';
    const DISCOUNT_SUBTOTAL_PERCENTAGE  = '%';
    const DISCOUNT_CATEGORY             = '-c';
    const DISCOUNT_CATEGORY_PERCENTAGE  = '%c';
    const DISCOUNT_SHIPPING             = '-s';
    const DISCOUNT_SHIPPING_PERCENTAGE  = '%s';

    const REDEEM_WEB    = 'web';
    const REDEEM_FAIR   = 'fairs';
    const REDEEM_BOTH   = 'both';

    /**
     * @var int
     */
    protected $voucherId;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var string
     */
    protected $redeemable;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var bool
     */
    protected $limitCustomer = false;

    /**
     * @var int
     */
    protected $noPerCustomer;

    /**
     * @var float
     */
    protected $minCartCost;

    /**
     * @var string
     */
    protected $discountOperation;

    /**
     * @var float
     */
    protected $discountAmount;

    /**
     * @var DateTime
     */
    protected $startDate;

    /**
     * @var DateTime|null
     */
    protected $expiry;

    /**
     * @var VoucherZoneCollection
     */
    protected $zones;

    /**
     * @var ProductCategoryCollection
     */
    protected $productCategories;

    /**
     * @return int
     */
    public function getVoucherId()
    {
        return $this->voucherId;
    }

    /**
     * @param int $voucherId
     * @return VoucherCodeModel
     */
    public function setVoucherId($voucherId)
    {
        $this->voucherId = $voucherId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return VoucherCodeModel
     */
    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return VoucherCodeModel
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Proxy for isActive method
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isActive();
    }

    /**
     * @param bool $active
     * @return VoucherCodeModel
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedeemable()
    {
        return $this->redeemable;
    }

    /**
     * @param string $redeemable
     */
    public function setRedeemable($redeemable)
    {
        $this->redeemable = $redeemable;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return VoucherCodeModel
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLimitCustomer()
    {
        return $this->limitCustomer;
    }

    /**
     * @param bool $limitCustomer
     */
    public function setLimitCustomer($limitCustomer)
    {
        $this->limitCustomer = $limitCustomer;
    }

    /**
     * @return int
     */
    public function getNoPerCustomer()
    {
        return $this->noPerCustomer;
    }

    /**
     * @param int $noPerCustomer
     */
    public function setNoPerCustomer($noPerCustomer)
    {
        $this->noPerCustomer = $noPerCustomer;
    }

    /**
     * @return float
     */
    public function getMinCartCost()
    {
        return $this->minCartCost;
    }

    /**
     * @param float $minCartCost
     * @return VoucherCodeModel
     */
    public function setMinCartCost($minCartCost)
    {
        $this->minCartCost = $minCartCost;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountOperation()
    {
        return $this->discountOperation;
    }

    /**
     * @return float
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @param float $discountAmount
     * @return VoucherCodeModel
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
        return $this;
    }

    /**
     * @param string $discountOperation
     * @return VoucherCodeModel
     */
    public function setDiscountOperation($discountOperation)
    {
        $this->discountOperation = $discountOperation;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     * @return VoucherCodeModel
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * @param DateTime|null $expiry
     * @return VoucherCodeModel
     */
    public function setExpiry(DateTime $expiry = null)
    {
        $this->expiry = $expiry;
        return $this;
    }

    /**
     * @return VoucherZoneCollection
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * @param VoucherZoneCollection $zones
     * @return VoucherCodeModel
     */
    public function setZones(VoucherZoneCollection $zones)
    {
        $this->zones = $zones;
        return $this;
    }

    /**
     * @return ProductCategoryCollection
     */
    public function getProductCategories()
    {
        return $this->productCategories;
    }

    /**
     * @param ProductCategoryCollection $productCategories
     * @return VoucherCodeModel
     */
    public function setProductCategories(ProductCategoryCollection $productCategories)
    {
        $this->productCategories = $productCategories;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'voucherId'         => $this->getVoucherId(),
            'code'              => $this->getCode(),
            'description'       => $this->getDescription(),
            'active'            => $this->isActive(),
            'redeemable'        => $this->getRedeemable(),
            'quantity'          => $this->getQuantity(),
            'limitCustomer'     => $this->isLimitCustomer(),
            'noPerCustomer'     => $this->getNoPerCustomer(),
            'minCartCost'       => $this->getMinCartCost(),
            'discountOperation' => $this->getDiscountOperation(),
            'discountAmount'    => $this->getDiscountAmount(),
            'startDate'         => $this->getStartDate(),
            'expiry'            => $this->getExpiry(),
            'productCategories' => $this->getProductCategories()->toArray(),
            'zones'             => $this->getZones()->toArray(),
        ];
    }
}
