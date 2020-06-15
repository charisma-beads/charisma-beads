<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use Common\Model\DateCreatedTrait;
use Common\Model\DateModifiedTrait;
use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Address
 *
 * @package Shop\Model
 */
class CustomerAddressModel implements ModelInterface
{
    use Model,
        DateCreatedTrait,
        DateModifiedTrait;
    
    /**
     * @var int
     */
    protected $customerAddressId;
    
    /**
     * @var int
     */
    protected $customerId;
    
    /**
     * @var int
     */
    protected $countryId;
    
    /**
     * @var int
     */
    protected $provinceId;
    
    /**
     * @var string
     */
    protected $address1;
    
    /**
     * @var string
     */
    protected $address2;
    
    /**
     * @var string
     */
    protected $address3;
    
    /**
     * @var string
     */
    protected $city;
    
    /**
     * @var string
     */
    protected $county;
    
    /**
     * @var string
     */
    protected $postcode;
    
    /**
     * @var string
     */
    protected $phone;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var CountryModel
     */
    protected $country;
    
    /**
     * @var CountryProvinceModel
     */
    protected $province;
    
	/**
	 * @return number $customerAddressId
	 */
	public function getCustomerAddressId()
	{
		return $this->customerAddressId;
	}

    /**
     * @param $addressId
     * @return $this
     */
	public function setCustomerAddressId($addressId)
	{
		$this->customerAddressId = $addressId;
		return $this;
	}

	/**
	 * @return number
	 */
	public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return CustomerAddressModel
     */
	public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

	/**
	 * @return number $countryId
	 */
	public function getCountryId()
	{
		return $this->countryId;
	}

    /**
     * @param $countryId
     * @return $this
     */
	public function setCountryId($countryId)
	{
		$this->countryId = $countryId;
		return $this;
	}

	/**
	 * @return number
	 */
	public function getProvinceId()
	{
		return $this->provinceId;
	}

	/**
	 * @param int $provinceId
	 * @return CustomerAddressModel
	 */
	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
		return $this;
	}

	/**
	 * @return string $address1
	 */
	public function getAddress1()
	{
		return $this->address1;
	}

    /**
     * @param $address1
     * @return $this
     */
	public function setAddress1($address1)
	{
		$this->address1 = $address1;
		return $this;
	}

	/**
	 * @return string $address2
	 */
	public function getAddress2()
	{
		return $this->address2;
	}

    /**
     * @param string $address2
     * @return $this
     */
	public function setAddress2($address2)
	{
		$this->address2 = $address2;
		return $this;
	}

	/**
	 * @return string $address3
	 */
	public function getAddress3()
	{
		return $this->address3;
	}

    /**
     * @param string $address3
     * @return $this
     */
	public function setAddress3($address3)
	{
		$this->address3 = $address3;
		return $this;
	}

	/**
	 * @return string $city
	 */
	public function getCity()
	{
		return $this->city;
	}

    /**
     * @param string $city
     * @return $this
     */
	public function setCity($city)
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string $county
	 */
	public function getCounty()
	{
		return $this->county;
	}

    /**
     * @param string $county
     * @return $this
     */
	public function setCounty($county)
	{
		$this->county = $county;
		return $this;
	}

	/**
	 * @return string $postcode
	 */
	public function getPostcode()
	{
		return $this->postcode;
	}

    /**
     * @param string $postcode
     * @return $this
     */
	public function setPostcode($postcode)
	{
		$this->postcode = $postcode;
		return $this;
	}

	/**
	 * @return string $phone
	 */
	public function getPhone()
	{
		return $this->phone;
	}

    /**
     * @param string $phone
     * @return $this
     */
	public function setPhone($phone)
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return string $email
	 */
	public function getEmail()
	{
		return $this->email;
	}

    /**
     * @param string $email
     * @return $this
     */
	public function setEmail($email)
	{
		$this->email = $email;
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
	 * @param CountryModel $country\
	 * @return CustomerAddressModel
	 */
	public function setCountry(CountryModel $country)
	{
	    $this->country = $country;
	    return $this;
	}
	
	/**
	 * @return CountryProvinceModel
	 */
	public function getProvince()
	{
		return $this->province;
	}

	/**
	 * @param CountryProvinceModel $province
	 * @return CustomerAddressModel
	 */
	public function setProvince(CountryProvinceModel $province)
	{
		$this->province = $province;
		return $this;
	}

}
