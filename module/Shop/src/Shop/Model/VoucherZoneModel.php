<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class VoucherZoneModel
 *
 * @package Shop\Model
 */
class VoucherZoneModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $zoneId;

    /**
     * @return int
     */
    public function getZoneId()
    {
        return $this->zoneId;
    }

    /**
     * @param int $zoneId
     * @return VoucherZoneModel
     */
    public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;
        return $this;
    }
}