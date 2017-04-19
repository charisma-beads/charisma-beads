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

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class CustomerMap
 *
 * @package Shop\Model\Voucher
 */
class CustomerMap implements ModelInterface
{
    use Model;

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
    protected $count;

    /**
     * @return int
     */
    public function getVoucherId(): int
    {
        return $this->voucherId;
    }

    /**
     * @param int $voucherId
     * @return CustomerMap
     */
    public function setVoucherId(int $voucherId): CustomerMap
    {
        $this->voucherId = $voucherId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return CustomerMap
     */
    public function setCustomerId(int $customerId): CustomerMap
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
     * @return CustomerMap
     */
    public function setCount(int $count): CustomerMap
    {
        $this->count = $count;
        return $this;
    }
}