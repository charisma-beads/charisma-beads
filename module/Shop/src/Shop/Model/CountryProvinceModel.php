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

use Common\Model\Model;
use Common\Model\ModelInterface;


/**
 * Class Province
 *
 * @package Shop\Model
 */
class CountryProvinceModel implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $provinceId;
    
    /**
     * @var int
     */
    protected $countryId;
    
    /**
     * @var string
     */
    protected $provinceCode;
    
    /**
     * @var string
     */
    protected $provinceName;
    
    /**
     * @var string
     */
    protected $provinceAlternateNames;
    
    /**
     * @var CountryModel
     */
    protected $country;
    
    /**
     * @return number
     */
	public function getProvinceId()
	{
		return $this->provinceId;
	}

	/**
	 * @param int $provinceId
	 * @return CountryProvinceModel
	 */
	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
		return $this;
	}

	/**
	 * @return number
	 */
	public function getCountryId()
	{
		return $this->countryId;
	}

	/**
	 * @param int $countryId
	 * @return CountryProvinceModel
	 */
	public function setCountryId($countryId)
	{
		$this->countryId = $countryId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProvinceCode()
	{
		return $this->provinceCode;
	}

	/**
	 * @param string $countryProvinceCode
	 * @return CountryProvinceModel
	 */
	public function setProvinceCode($countryProvinceCode)
	{
		$this->provinceCode = $countryProvinceCode;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProvinceName()
	{
		return $this->provinceName;
	}

	/**
	 * @param string $provinceName
	 * @return CountryProvinceModel
	 */
	public function setProvinceName($provinceName)
	{
		$this->provinceName = $provinceName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProvinceAlternateNames()
	{
		return $this->provinceAlternateNames;
	}

	/**
	 * @param string $provinceAlternateNames
	 * @return CountryProvinceModel
	 */
	public function setProvinceAlternateNames($provinceAlternateNames)
	{
		$this->provinceAlternateNames = $provinceAlternateNames;
		return $this;
	}

	/**
	 * @return CountryModel
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param CountryModel $country
	 * @return CountryProvinceModel
	 */
	public function setCountry(CountryModel $country)
	{
		$this->country = $country;
		return $this;
	}
}
