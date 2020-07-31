<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Zone
 *
 * @package Shop\Model
 */
class PostZoneModel implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $postZoneId;
    
    /**
     * @var int
     */
    protected $taxCodeId;
    
    /**
     * @var string
     */
    protected $zone;
    
	/**
	 * @return number $postZoneId
	 */
	public function getPostZoneId()
	{
		return $this->postZoneId;
	}

    /**
     * @param number $postZoneId
     * @return PostZoneModel
     */
	public function setPostZoneId($postZoneId)
	{
		$this->postZoneId = $postZoneId;
		return $this;
	}

	/**
	 * @return number $taxCodeId
	 */
	public function getTaxCodeId()
	{
		return $this->taxCodeId;
	}

    /**
     * @param number $taxCodeId
     * @return PostZoneModel
     */
	public function setTaxCodeId($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

	/**
	 * @return string $zone
	 */
	public function getZone()
	{
		return $this->zone;
	}

    /**
     * @param string $zone
     * @return PostZoneModel
     */
	public function setZone($zone)
	{
		$this->zone = $zone;
		return $this;
	}
}
