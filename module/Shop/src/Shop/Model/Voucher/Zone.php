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
 * Class Zone
 *
 * @package Shop\Model\Voucher
 */
class Zone implements ModelInterface
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
     * @return Zone
     */
    public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;
        return $this;
    }
}