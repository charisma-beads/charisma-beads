<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class PostZone extends AbstractModel
{
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
	public function getPostZoneId ()
	{
		return $this->postZoneId;
	}

	/**
	 * @param number $postZoneId
	 */
	public function setPostZoneId ($postZoneId)
	{
		$this->postZoneId = $postZoneId;
		return $this;
	}

	/**
	 * @return number $taxCodeId
	 */
	public function getTaxCodeId ()
	{
		return $this->taxCodeId;
	}

	/**
	 * @param number $taxCodeId
	 */
	public function setTaxCodeId ($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

	/**
	 * @return string $zone
	 */
	public function getZone ()
	{
		return $this->zone;
	}

	/**
	 * @param string $zone
	 */
	public function setZone ($zone)
	{
		$this->zone = $zone;
		return $this;
	}
}