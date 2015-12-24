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


/**
 * Class Province
 *
 * @package Shop\Model\Country
 */
class Province implements ModelInterface
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
     * @var int
     */
    protected $lft;
    
    /**
     * @var int
     */
    protected $rgt;
    
    /**
     * @var Country
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
	 * @return \Shop\Model\Country\Province
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
	 * @return \Shop\Model\Country\Province
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
	 * @return \Shop\Model\Country\Province
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
	 * @return \Shop\Model\Country\Province
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
	 * @return \Shop\Model\Country\Province
	 */
	public function setProvinceAlternateNames($provinceAlternateNames)
	{
		$this->provinceAlternateNames = $provinceAlternateNames;
		return $this;
	}

	/**
	 * @return number
	 */
	public function getLft()
	{
		return $this->lft;
	}

	/**
	 * @param int $lft
	 * @return \Shop\Model\Country\Province
	 */
	public function setLft($lft)
	{
		$this->lft = $lft;
		return $this;
	}

	/**
	 * @return number
	 */
	public function getRgt()
	{
		return $this->rgt;
	}

	/**
	 * @param int $rgt
	 * @return \Shop\Model\Country\Province
	 */
	public function setRgt($rgt)
	{
		$this->rgt = $rgt;
		return $this;
	}

	/**
	 * @return Country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param Country $country
	 * @return \Shop\Model\Country\Province
	 */
	public function setCountry(Country $country)
	{
		$this->country = $country;
		return $this;
	}
}
