<?php
namespace Shop\Model\Country;

use Shop\Model\Country;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Province implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $countryProvinceId;
    
    /**
     * @var int
     */
    protected $countryId;
    
    /**
     * @var string
     */
    protected $countryProvinceCode;
    
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
     * @var \Shop\Model\Country
     */
    protected $country;
    
    /**
     * @return number
     */
	public function getCountryProvinceId()
	{
		return $this->countryProvinceId;
	}

	/**
	 * @param int $countryProvinceId
	 * @return \Shop\Model\Country\Province
	 */
	public function setCountryProvinceId($countryProvinceId)
	{
		$this->countryProvinceId = $countryProvinceId;
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
	public function getCountryProvinceCode()
	{
		return $this->countryProvinceCode;
	}

	/**
	 * @param string $countryProvinceCode
	 * @return \Shop\Model\Country\Province
	 */
	public function setCountryProvinceCode($countryProvinceCode)
	{
		$this->countryProvinceCode = $countryProvinceCode;
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
	 * @return \Shop\Model\Country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param \Shop\Model\Country $country
	 * @return \Shop\Model\Country\Province
	 */
	public function setCountry(Country $country)
	{
		$this->country = $country;
		return $this;
	}
}
