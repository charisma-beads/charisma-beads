<?php
namespace Shop\Model;

use Application\Model\AbstractModel;
use DateTime;

class CustomerAddress extends AbstractModel
{
    /**
     * @var int
     */
    protected $customerAddressId;
    
    /**
     * @var int
     */
    protected $userId;
    
    /**
     * @var int
     */
    protected $countryId;
    
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
     * @var DateTime
     */
    protected $dateCreated;
    
    /**
     * @var DateTime
     */
    protected $dateModified;
    
	/**
	 * @return number $customerAddressId
	 */
	public function getCustomerAddressId ()
	{
		return $this->addressId;
	}

	/**
	 * @param number $customerAddressId
	 */
	public function setCustomerAddressId ($addressId)
	{
		$this->customerAddressId = $addressId;
		return $this;
	}

	/**
	 * @return number $userId
	 */
	public function getUserId ()
	{
		return $this->userId;
	}

	/**
	 * @param number $userId
	 */
	public function setUserId ($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @return number $countryId
	 */
	public function getCountryId ()
	{
		return $this->countryId;
	}

	/**
	 * @param number $countryId
	 */
	public function setCountryId ($countryId)
	{
		$this->countryId = $countryId;
		return $this;
	}

	/**
	 * @return string $address1
	 */
	public function getAddress1 ()
	{
		return $this->address1;
	}

	/**
	 * @param string $address1
	 */
	public function setAddress1 ($address1)
	{
		$this->address1 = $address1;
		return $this;
	}

	/**
	 * @return string $address2
	 */
	public function getAddress2 ()
	{
		return $this->address2;
	}

	/**
	 * @param string $address2
	 */
	public function setAddress2 ($address2)
	{
		$this->address2 = $address2;
		return $this;
	}

	/**
	 * @return string $address3
	 */
	public function getAddress3 ()
	{
		return $this->address3;
	}

	/**
	 * @param string $address3
	 */
	public function setAddress3 ($address3)
	{
		$this->address3 = $address3;
		return $this;
	}

	/**
	 * @return string $city
	 */
	public function getCity ()
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 */
	public function setCity ($city)
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string $county
	 */
	public function getCounty ()
	{
		return $this->county;
	}

	/**
	 * @param string $county
	 */
	public function setCounty ($county)
	{
		$this->county = $county;
		return $this;
	}

	/**
	 * @return string $postcode
	 */
	public function getPostcode ()
	{
		return $this->postcode;
	}

	/**
	 * @param string $postcode
	 */
	public function setPostcode ($postcode)
	{
		$this->postcode = $postcode;
		return $this;
	}

	/**
	 * @return string $phone
	 */
	public function getPhone ()
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone ($phone)
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return DateTime $dateCreated
	 */
	public function getDateCreated ()
	{
		return $this->dateCreated;
	}

	/**
	 * @param DateTime $dateCreated
	 */
	public function setDateCreated ($dateCreated)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}

	/**
	 * @return DateTime $dateModified
	 */
	public function getDateModified ()
	{
		return $this->dateModified;
	}

	/**
	 * @param DateTime $dateModified
	 */
	public function setDateModified ($dateModified)
	{
		$this->dateModified = $dateModified;
		return $this;
	}
}
