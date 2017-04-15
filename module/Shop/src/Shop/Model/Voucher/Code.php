<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Model\Voucher;

use DateTime;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Codes
 *
 * @package Shop\Model\Voucher
 */
class Code implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $voucherId;

    /**
     * @var string
     */
    protected $code;

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
     * @var DateTime
     */
    protected $startDate;

    /**
     * @var DateTime|null
     */
    protected $expiry;

    /**
     * @var ZoneCollection
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
     * @return Code
     */
    public function setVoucherId(int $voucherId)
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
     * @return Code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
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
     * @return Code
     */
    public function setActive(bool $active)
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
     * @return Code
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLimitCustomer(): bool
    {
        return $this->limitCustomer;
    }

    /**
     * @param bool $limitCustomer
     */
    public function setLimitCustomer(bool $limitCustomer)
    {
        $this->limitCustomer = $limitCustomer;
    }

    /**
     * @return int
     */
    public function getNoPerCustomer(): int
    {
        return $this->noPerCustomer;
    }

    /**
     * @param int $noPerCustomer
     */
    public function setNoPerCustomer(int $noPerCustomer)
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
     * @return Code
     */
    public function setMinCartCost(float $minCartCost)
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
     * @param string $discountOperation
     * @return Code
     */
    public function setDiscountOperation(string $discountOperation)
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
     * @return Code
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
     * @return Code
     */
    public function setExpiry(DateTime $expiry = null)
    {
        $this->expiry = $expiry;
        return $this;
    }

    /**
     * @return ZoneCollection
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * @param ZoneCollection $zones
     * @return Code
     */
    public function setZones(ZoneCollection $zones)
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
     * @return Code
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
            'active'            => $this->isActive(),
            'redeemable'        => $this->getRedeemable(),
            'quantity'          => $this->getQuantity(),
            'limitCustomer'     => $this->isLimitCustomer(),
            'noPerCustomer'     => $this->getNoPerCustomer(),
            'minCartCost'       => $this->getMinCartCost(),
            'discountOperation' => $this->getDiscountOperation(),
            'startDate'         => $this->getStartDate(),
            'expiry'            => $this->getExpiry(),
            'productCategories' => $this->getProductCategories()->toArray(),
            'zones'             => $this->getZones()->toArray(),
        ];
    }
}
