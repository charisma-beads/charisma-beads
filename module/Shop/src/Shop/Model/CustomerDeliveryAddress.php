<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class CustomerDeliveryAddress extends AbstractModel
{
    /**
     * @var int
     */
    protected $customerDeliveryAddressId;
    
    /**
     * @var int
     */
    protected $customerAddressId;
    
	/**
	 * @return number $customerDeliveryAddressId
	 */
	public function getCustomerDeliveryAddressId ()
	{
		return $this->customerDeliveryAddressId;
	}

	/**
	 * @param number $customerDeliveryAddressId
	 */
	public function setCustomerDeliveryAddressId ($customerDeliveryAddressId)
	{
		$this->customerDeliveryAddressId = $customerDeliveryAddressId;
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
