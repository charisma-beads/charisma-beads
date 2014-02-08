<?php
namespace Shop\View;

use Shop\Model\Customer\Address;
use Application\View\AbstractViewHelper;

class FormatAddress extends AbstractViewHelper
{
    protected $customerAddressService;
    
    public function getDeliveryAddress($userId=null)
    {
        if (!$userId) {
            $userId = $this->getIdentity()->getUserId();
        }
        
        $address = $this->getCustomerAddressService()->getDeliveryAddressByUserId($userId);
        return $this->formatAddress($address);
    }
    
    public function getBillingAddress($userId=null)
    {
        if (!$userId) {
        	$userId = $this->getIdentity()->getUserId();
        }
        
        $address = $this->getCustomerAddressService()->getBillingAddressByUserId($userId);
        return $this->formatAddress($address, true);
    }
    
    public function formatAddress(Address $address, $includeEmail=false)
    {
        $identity = $this->view->plugin('identity');
        $html = $identity()->getFullName() . '<br>';
        
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
        $html .= $address->getCountry() .'<br><br>';
        $html .= $address->getPhone() . '<br>';
        
        if ($includeEmail) {
            $html .= $identity()->getEmail();
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
