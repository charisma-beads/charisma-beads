<?php
namespace Shop\Form\Country;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Province extends Form implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        
    }
    
    public function getCountryList()
    {
        $countries = $this->getCountryService()->fetchAll();
        $countryOptions = array();
         
        foreach($countries as $country) {
            $countryOptions[$country->getCountryId()] = $country->getCountry();
        }
    
        return $countryOptions;
    }
    
    /**
     * @return \Shop\Service\Country
     */
    public function getCountryService()
    {
        return $this->getServiceLocator()->get('Shop\Service\Country');
    }
}
