<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

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