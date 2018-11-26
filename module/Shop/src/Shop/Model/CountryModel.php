<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Country
 *
 * @package Shop\Model
 */
class CountryModel implements ModelInterface
{
    use Model;
    
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
	 * @var string
	 */
	protected $code;
	
	/**
	 * @var PostZoneModel
	 */
	protected $postZone;
	
	/**
	 * @return number $countryId
	 */
	public function getCountryId()
	{
		return $this->countryId;
	}

    /**
     * @param number $countryId
     * @return CountryModel
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
     * @return CountryModel
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
     * @return CountryModel
     */
	public function setCountry($country)
	{
		$this->country = $country;
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
     * @return CountryModel
     */
	public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * @return PostZoneModel
     */
	public function getPostZone()
    {
        return $this->postZone;
    }

    /**
     * @param PostZoneModel $zone
     * @return CountryModel
     */
	public function setPostZone(PostZoneModel $zone)
    {
        $this->postZone = $zone;
        return $this;
    }
}
