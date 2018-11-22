<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Model\Customer;

use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;
use UthandoUser\Model\UserModel;

/**
 * Class Customer
 *
 * @package Shop\Model\Customer
 */
class Customer implements ModelInterface
{
    use Model,
        DateModifiedTrait,
        DateCreatedTrait;

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
     * @var int
     */
    protected $number;

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
     * @var User
     */
    protected $user;

    /**
     * @var Prefix
     */
    protected $prefix;

    /**
     * @var Address
     */
    protected $billingAddress;

    /**
     * @var Address
     */
    protected $deliveryAddress;

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrefixId()
    {
        return $this->prefixId;
    }

    /**
     * @param int $prefixId
     * @return $this
     */
    public function setPrefixId($prefixId)
    {
        $this->prefixId = $prefixId;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return int
     */
    public function getBillingAddressId()
    {
        return $this->billingAddressId;
    }

    /**
     * @param int $billingAddressId
     * @return $this
     */
    public function setBillingAddressId($billingAddressId)
    {
        $this->billingAddressId = $billingAddressId;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeliveryAddressId()
    {
        return $this->deliveryAddressId;
    }

    /**
     * @param int $deliveryAddressId
     * @return $this
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
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(UserModel $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Prefix
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param Prefix $prefix
     * @return $this
     */
    public function setPrefix(Prefix $prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     * @return $this
     */
    public function setBillingAddress(Address $billingAddress)
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    /**
     * @return Address
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * @param Address $deliveryAddress
     * @return $this
     */
    public function setDeliveryAddress(Address $deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastNameFirst()
    {
        return $this->getLastname() . ', ' . $this->getFirstname();
    }
}
