<?php
namespace Shop\Model;

use Application\Model\Model;
use Application\Model\ModelInterface;
use Application\Model\RelationalModel;

class Country implements ModelInterface
{
    use Model, RelationalModel;
    
	/**
	 * @var int
	 */
	protected $countryId;
	
	/**
	 * @var int
	 */
	protected $postZoneId;
	
	/**
	 * @var string
	 */
	protected $country;
	
	/**
	 * @return number $countryId
	 */
	public function getCountryId()
	{
		return $this->countryId;
	}

	/**
	 * @param number $countryId
	 */
	public function setCountryId($countryId)
	{
		$this->countryId = $countryId;
		return $this;
	}

	/**
	 * @return number $postZoneId
	 */
	public function getPostZoneId()
	{
		return $this->postZoneId;
	}

	/**
	 * @param number $postZoneId
	 */
	public function setPostZoneId($postZoneId)
	{
		$this->postZoneId = $postZoneId;
		return $this;
	}

	/**
	 * @return string $country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	public function setCountry($country)
	{
		$this->country = $country;
		return $this;
	}
}
