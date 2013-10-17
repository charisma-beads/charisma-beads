<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class CustomerBillingAddress extends AbstractModel
{
    /**
     * @var int
     */
    protected $customerBillingAddressId;
    
    /**
     * @var int
     */
    protected $customerAddressId;
    
	/**
	 * @return number $customerBillingAddressId
	 */
	public function getCustomerBillingAddressId ()
	{
		return $this->customerBillingAddressId;
	}

	/**
	 * @param number $customerBillingAddressId
	 */
	public function setCustomerBillingAddressId ($customerBillingAddressId)
	{
		$this->customerBillingAddressId = $customerBillingAddressId;
		return $this;
	}

	/**
	 * @return number $customerAddressId
	 */
	public function getCustomerAddressId ()
	{
		return $this->customerAddressId;
	}

	/**
	 * @param number $customerAddressId
	 */
	public function setCustomerAddressId ($customerAddressId)
	{
		$this->customerAddressId = $customerAddressId;
		return $this;
	}

}
