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
 * Class ZoneMap
 *
 * @package Shop\Model\Voucher
 */
class ZoneMap implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $voucherId;

    /**
     * @var int
     */
    protected $zoneId;

    /**
     * @return int
     */
    public function getVoucherId(): int
    {
        return $this->voucherId;
    }

    /**
     * @param int $voucherId
     * @return ZoneMap
     */
    public function setVoucherId(int $voucherId): ZoneMap
    {
        $this->voucherId = $voucherId;
        return $this;
    }

    /**
     * @return int
     */
    public function getZoneId(): int
    {
        return $this->zoneId;
    }

    /**
     * @param int $zoneId
     * @return ZoneMap
     */
    public function setZoneId(int $zoneId): ZoneMap
    {
        $this->zoneId = $zoneId;
        return $this;
    }
}