<?php
namespace Shop\Service\Customer;

use UthandoCommon\Service\AbstractMapperService;

class Address extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Customer\Address';
    protected $form = 'Shop\Form\Customer\Address';
    protected $inputFilter = 'Shop\InputFilter\Customer\Address';

    protected $serviceAlias = 'ShopCustomerAddress';
    
    /**
     * @var \Shop\Service\Country
     */
    protected $countryService;
    
    /**
     * @var \Shop\Service\Country\Province
     */
    protected $provinceService;
    
    /**
     * @var \Shop\Service\Customer
     */
    protected $customerService;
    
    public function getFullAddressById($id)
    {
        $id = (int) $id;
        $address = $this->getById($id);
        
        $this->populate($address, true);
        
        return $address;
        
    }
    
    public function getAllAddressesByCustomerId($customerId)
    {
        $customerId = (int) $customerId;
        
        $addresses = $this->getMapper()->getAllByCustomerId($customerId);
        
        foreach ($addresses as $address) {
        	$address = $this->populate($address, true);
        }
        
        return $addresses;
    }
    
    public function getAllUserAddresses($userId)
    {
        $userId = (int) $userId;
        
        $customerId = $this->getCustomerService()
            ->getCustomerByUserId($userId)
            ->getCustomerId();
        
        return $this->getAllAddressesByCustomerId($customerId);
    }
    
    public function getAddressByUserId($userId, $billingOrDelivery)
    {
        $userId = (int) $userId;
        $billingOrDelivery = (string) $billingOrDelivery;
    
        $address = $this->getMapper()->getAddressByUserId($userId, $billingOrDelivery);
        $this->populate($address, true);
    
        return $address;
    }
    
    /**
     * @param $model \Shop\Model\Customer\Address
     * @param $children bool|array
     */
    public function populate($model, $children = false)
    {
        $allChildren = ($children === true) ? true : false;
        $children = (is_array($children)) ? $children : array();
        
        if ($allChildren || in_array('country', $children)) {
            $model->setCountry(
                $this->getCountryService()
                    ->getById($model->getCountryId())
            );
        }
        
        if ($allChildren || in_array('country', $children)) {
        	$model->setProvince(
        			$this->getProvinceService()
                        ->getById($model->getProvinceId())
        	);
        }
    }
    
    /**
     * @return \Shop\Service\Country
     */
    public function getCountryService()
    {
        if (!$this->countryService) {
            $sl = $this->getServiceLocator();
            $this->countryService = $sl->get('Shop\Service\Country');
        }
    
        return $this->countryService;
    }
    
    /**
     * @return \Shop\Service\Country\Province
     */
    public function getProvinceService()
    {
    	if (!$this->provinceService) {
    		$sl = $this->getServiceLocator();
    		$this->provinceService = $sl->get('Shop\Service\Country\Province');
    	}
    
    	return $this->provinceService;
    }
    
    /**
     * @return \Shop\Service\Customer
     */
    public function getCustomerService()
    {
    	if (!$this->customerService) {
    		$sl = $this->getServiceLocator();
    		$this->customerService = $sl->get('Shop\Service\Customer');
    	}
    
    	return $this->customerService;
    }
}