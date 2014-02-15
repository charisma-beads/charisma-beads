<?php
namespace Shop\Service\Customer;

use Application\Service\AbstractService;

class Address extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\CustomerAddress';
    protected $form = 'Shop\Form\CustomerAddress';
    protected $inputFilter = 'Shop\InputFilter\CustomerAddress';
    
    /**
     * @var \Shop\Service\Country
     */
    protected $countryService;
    
    public function getFullAddressById($id)
    {
        $id = (int) $id;
        $address = $this->getById($id);
        
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
    }
    
    public function getBillingAddressByUserId($userId)
    {
        return $this->getMapper()->getBillingAddressByUserId($userId);
    }
    
    public function getDeliveryAddressByUserId($userId)
    {
        return $this->getMapper()->getDeliveryAddressByUserId($userId);
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
}