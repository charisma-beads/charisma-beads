<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Shop\Model\Customer\Address;
use Shop\Model\Order\Order;
use UthandoCommon\Service\ServiceManager;
use UthandoCommon\View\AbstractViewHelper;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\View\Helper\Identity;
use Shop\Model\Customer\Customer;

/**
 * Class CustomerAddress
 *
 * @package Shop\View
 */
class CustomerAddress extends AbstractViewHelper
{
    /**
     * @var \Shop\Service\Customer\Address
     */
    protected $customerAddressService;
    
    /**
     * @var Customer
     */
    protected $customer;
    
    /**
     * @var Order
     */
    protected $order;
    
    /**
     * @var Address
     */
    protected $address;
    
    /**
     * @var string
     */
    protected $userId;
    
    /**
     * @var bool
     */
    protected $includeName = false;
    
    /**
     * @var bool
     */
    protected $includeEmail = false;
    
    protected $identity;
    
    public function __invoke()
    {
        // reset some variables on each call.
    	$this->includeEmail = false;
    	$this->includeName = false;
    	
        return $this;
    }
    
    /**
     * @return string
     */
    public function render()
    {
        return $this->formatAddress();
    }
    
    /**
     * @param Address $address
     * @throws InvalidArgumentException
     * @return string
     */
    public function formatAddress(Address $address=null)
    {
        if (null === $address) {
            $address = $this->getAddress();
        }
        
        if (!$address instanceof Address) {
            throw new InvalidArgumentException('Address must in an instance of \Shop\Model\Customer\Address');
        }
        
        $identity = $this->getIdentity();
        $html = '';
        
        if ($this->includeName) {
            
            if ($this->order instanceof Order) {
                $html .= $this->order->getMetadata()->getCustomerName() . '<br>';
            } elseif ($this->customer instanceof Customer) {
                
                $prefix = $this->customer->getPrefix()->getPrefix();
                $name = $this->customer->getFullName();
                
                $html .= join(' ', [
                    $prefix,
                    $name,
                    '<br>',
                ]);
            } else {
                $html .= $identity->getFullName() . '<br>';
            }
        }
        
        $html .= $address->getAddress1() . '<br>';
        
        if ($address->getAddress2()) {
        	$html .= $address->getAddress2() . '<br>';
        }
        
        if ($address->getAddress3()) {
        	$html .= $address->getAddress3() . '<br>';
        }
        
        $html .= $address->getCity() . '<br>';
        $html .= $address->getProvince()->getProvinceName() . '<br>';
        $html .= $address->getPostcode() . '<br>';
        $html .= $address->getCountry()->getCountry() .'<br><br>';
        $html .= $address->getPhone() . '<br>';

        if ($this->includeEmail) {
            $html .= ($this->order instanceof Order) ?
                $this->order->getMetadata()->getEmail() : $identity->getEmail();
        }
        
        return $html;
    }
    
    /**
     * @return \Shop\Model\Order\Order
     */
    public function getOrder()
    {
    	return $this->order;
    }
    
    /**
     * @param Order $order
     * @return \Shop\View\CustomerAddress
     */
    public function setOrder(Order $order)
    {
    	$this->order = $order;
    
    	return $this;
    }
    
    /**
     * @return Customer $customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return $this
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

 /**
     * @return \Shop\Model\Customer\Address
     */
    public function getAddress()
    {
    	return $this->address;
    }
    
    /**
     * @param string $billingOrDelivery
     * @return \Shop\View\CustomerAddress
     */
    public function setAddress($billingOrDelivery)
    {
    	$address = $this->getCustomerAddressService()
    	   ->getAddressByUserId($this->getUserId(), $billingOrDelivery);
    
    	$this->address = $address;
    
    	return $this;
    }
    
    /**
     * @return \Shop\View\CustomerAddress
     */
    public function includeEmail()
    {
        if (!$this->includeEmail) {
            $this->includeEmail = true;
        }
        
        return $this;
    }
    
    /**
     * @return \Shop\View\CustomerAddress
     */
    public function includeName()
    {
    	if (!$this->includeName) {
    		$this->includeName = true;
    	}
    
    	return $this;
    }
    
    /**
     * @return string
     */
    public function getUserId()
    {
        if (!$this->userId) {
            $this->setUserId();
        }
        return $this->userId;
    }
    
    /**
     * @param integer|null $userId
     * @return \Shop\View\CustomerAddress
     */
    public function setUserId($userId=null)
    {
        if (!$userId) {
        	$userId = $this->getIdentity()->getUserId();
        }
        
        $userId = (int) $userId;
        $this->userId = $userId;
        
        return $this;
    }
    
    /**
     * @return Identity
     */
    protected function getIdentity()
    {
        if (!$this->identity instanceof Identity) {
            $identity = $this->view->plugin('identity');
            $this->identity = $identity();
        }
        
        return $this->identity;
    }
    
    /**
     * @return \Shop\Service\Customer\Address
     */
    public function getCustomerAddressService()
    {
    	if (!$this->customerAddressService) {
    		$sl = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ServiceManager::class);
    		$this->customerAddressService = $sl->get('ShopCustomerAddress');
    	}
    	 
    	return $this->customerAddressService;
    }
}
