<?php
namespace Shop\View;

use Shop\Model\Customer\Address;
use Shop\Model\Order;
use UthandoCommon\View\AbstractViewHelper;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\View\Helper\Identity;

class CustomerAddress extends AbstractViewHelper
{
    protected $customerAddressService;
    
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
            $html .= ($this->order instanceof Order) ? $this->order->getMetadata()->getEmail() : $identity->getEmail();
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
    		$sl = $this->getServiceLocator()->getServiceLocator();
    		$this->customerAddressService = $sl->get('Shop\Service\Customer\Address');
    	}
    	 
    	return $this->customerAddressService;
    }
}
