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

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class CustomerMap
 *
 * @package Shop\Model
 */
class VoucherCustomerMapModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $voucherId;

    /**
     * @var int
     */
    protected $customerId;

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getVoucherId(): ?int
    {
        return $this->voucherId;
    }

    /**
     * @param int $voucherId
     * @return VoucherCustomerMapModel
     */
    public function setVoucherId(int $voucherId): VoucherCustomerMapModel
    {
        $this->voucherId = $voucherId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return VoucherCustomerMapModel
     */
    public function setCustomerId(int $customerId): VoucherCustomerMapModel
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return VoucherCustomerMapModel
     */
    public function setCount(int $count): VoucherCustomerMapModel
    {
        $this->count = $count;
        return $this;
    }
}