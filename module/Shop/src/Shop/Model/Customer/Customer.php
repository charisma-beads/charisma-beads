<?php
namespace Shop\Model\Customer;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use DateTime;

class Customer implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $customerId;
    
    /**
     * @var int
     */
    protected $userId;
    
    /**
     * @var int
     */
    protected $prefixId;
    
    /**
     * @var string
     */
    protected $firstname;
    
    /**
     * @var string
     */
    protected $lastname;
    
    /**
     * @var int
     */
    protected $billingAddressId;
    
    /**
     * @var int
     */
    protected $deliveryAddressId;
    
    /**
     * @var string
     */
    protected $email;
    
    /**
     * @var DateTime
     */
    protected $dateCreated;
    
    /**
     * @var DateTime
     */
    protected $dateModified;
    
    /**
     * @var \UthandoUser\Model\User
     */
    protected $user;
    
    /**
     * @var \Shop\Model\Customer\Prefix
     */
    protected $prefix;
    
    /**
     * @var \Shop\Model\Customer\Address
     */
    protected $billingAddress;
    
    /**
     * @var \Shop\Model\Customer\Address
     */
    protected $deliveryAddress;
    
	/**
	 * @return number $customerId
	 */
	public function getCustomerId()
	{
		return $this->customerId;
	}

	/**
	 * @param number $customerId
	 */
	public function setCustomerId($customerId)
	{
		$this->customerId = $customerId;
		return $this;
	}

	/**
	 * @return number $userId
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param number $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @return number $prefixId
	 */
	public function getPrefixId()
	{
		return $this->prefixId;
	}

	/**
	 * @param number $prefixId
	 */
	public function setPrefixId($prefixId)
	{
		$this->prefixId = $prefixId;
		return $this;
	}

	/**
	 * @return string $firstname
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
		return $this;
	}

	/**
	 * @return string $lastname
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * @param string $lastname
	 */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
		return $this;
	}

	/**
	 * @return number $billingAddressId
	 */
	public function getBillingAddressId()
	{
		return $this->billingAddressId;
	}

	/**
	 * @param number $billingAddressId
	 */
	public function setBillingAddressId($billingAddressId)
	{
		$this->billingAddressId = $billingAddressId;
		return $this;
	}

	/**
	 * @return number $deliveryAddressId
	 */
	public function getDeliveryAddressId()
	{
		return $this->deliveryAddressId;
	}

	/**
	 * @param number $deliveryAddressId
	 */
	public function setDeliveryAddressId($deliveryAddressId)
	{
		$this->deliveryAddressId = $deliveryAddressId;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getEmail()
	{
	    return $this->email;
	}
	
	/**
	 * @param string $email
	 * @return \Shop\Model\Customer
	 */
	public function setEmail($email)
	{
	    $this->email = $email;
	    return $this;
	}

	/**
	 * @return DateTime $dateCreated
	 */
	public function getDateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @param DateTime $dateCreated
	 */
	public function setDateCreated($dateCreated)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}

	/**
	 * @return DateTime $dateModified
	 */
	public function getDateModified()
	{
		return $this->dateModified;
	}

	/**
	 * @param DateTime $dateModified
	 */
	public function setDateModified($dateModified = null)
	{
		$this->dateModified = $dateModified;
		return $this;
	}
	
	/**
	 * @return \UthandoUser\Model\User
	 */
	public function getUser()
	{
	    return $this->user;
	}
	
	/**
	 * @param \UthandoUser\Model\User $user
	 * @return \Shop\Model\Customer
	 */
	public function setUser($user)
	{
	    $this->user = $user;
	    return $this;
	}
	
	/**
	 * @return \Shop\Model\Customer\Prefix
	 */
	public function getPrefix()
	{
	    return $this->prefix;
	}
	
	/**
	 * @param \Shop\Model\Customer\Prefix $prefix
	 * @return \Shop\Model\Customer
	 */
	public function setPrefix($prefix)
	{
	    $this->prefix = $prefix;
	    return $this;
	}
	
	/**
	 * @return \Shop\Model\Customer\Address
	 */
	public function getBillingAddress()
	{
	    return $this->billingAddress;
	}
	
	/**
	 * @param \Shop\Model\Customer\Address $billingAddress
	 * @return \Shop\Model\Customer
	 */
	public function setBillingAddress($billingAddress)
	{
	    $this->billingAddress = $billingAddress;
	    return $this;
	}
	
	/**
	 * @return \Shop\Model\Customer\Address
	 */
	public function getDeliveryAddress()
	{
	    return $this->deliveryAddress;
	}
	
	/**
	 * @param \Shop\Model\Customer\Address $deliveryAddress
	 * @return \Shop\Model\Customer
	 */
	public function setDeliveryAddress($deliveryAddress)
	{
	    $this->deliveryAddress = $deliveryAddress;
	    return $this;
	}
	
	public function getFullName()
	{
		return $this->getFirstname() . ' ' . $this->getLastname();
	}
	
	public function getLastNameFirst()
	{
		return $this->getLastname() . ', ' . $this->getFirstname();
	}
}
