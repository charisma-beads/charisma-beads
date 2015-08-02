<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model\Country;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use Shop\Model\Post\Zone;

/**
 * Class Country
 *
 * @package Shop\Model\Country
 */
class Country implements ModelInterface
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
	 * @var Zone
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
	
	/**
	 * @return string
	 */
	public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
	public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    
    /**
     * @return \Shop\Model\Post\Zone
     */
	public function getPostZone()
    {
        return $this->postZone;
    }

    /**
     * @param Zone $zone
     * @return \Shop\Model\Country
     */
	public function setPostZone(Zone $zone)
    {
        $this->postZone = $zone;
        return $this;
    }
}
