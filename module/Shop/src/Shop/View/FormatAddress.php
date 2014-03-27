<?php
namespace Shop\View;

use Shop\Model\Customer\Address;
use Shop\Model\Order;
use Application\View\AbstractViewHelper;

class FormatAddress extends AbstractViewHelper
{
    protected $customerAddressService;
    
    /**
     * @var Order
     */
    protected $order;
    
    public function __invoke(Order $obect = null)
    {
        $this->order = $obect;
        return $this;
    }
    
    public function getAddress($billingOrDelivery, $includeEmail = false, $userId = null)
    {
        if (!$userId) {
            $userId = $this->getIdentity()->getUserId();
        }
    
        $address = $this->getCustomerAddressService()->getAddressByUserId($userId, $billingOrDelivery);
        return $this->formatAddress($address, $includeEmail);
    }
    
    public function formatAddress(Address $address, $includeEmail = false)
    {
        $identity = $this->view->plugin('identity');
        
        if ($this->order instanceof Order) {
            $html = $this->order->getMetadata()->getCustomerName() . '<br>';
        } else {
            $html = $identity()->getFullName() . '<br>';
        }
        
        $html .= $address->getAddress1() . '<br>';
        
        if ($address->getAddress2()) {
        	$html .= $address->getAddress2() . '<br>';
        }
        
        if ($address->getAddress3()) {
        	$html .= $address->getAddress3() . '<br>';
        }
        
        $html .= $address->getCounty() . '<br>';
        $html .= $address->getCity() . '<br>';
        $html .= $address->getPostcode() . '<br>';
        $html .= $address->getCountry()->getCountry() .'<br><br>';
        $html .= $address->getPhone() . '<br>';
        
        if ($includeEmail) {
            $html .= $address->getEmail();
        }
        
        return $html;
    }
    
    protected function getIdentity()
    {
        $identity = $this->view->plugin('identity');
        return $identity();
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
