<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class CountryList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a country---';
    
    protected $countryId;
    
    public function setOptions($options)
    {
    	parent::setOptions($options);
    
    	if (isset($this->options['country_id'])) {
    		$this->setCountryId($this->options['country_id']);
    	}
    }
    
    public function getValueOptions()
    {
    	return ($this->valueOptions) ?: $this->getCountries();
    }
    
    public function getCountries()
    {
        $countries = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopCountry')
            ->fetchAll();
        
        $countryOptions = [];
         
        foreach($countries as $country) {
        	$countryOptions[] = [
        	   'label' => $country->getCountry(),
        	   'value' => $country->getCountryId(),
        	   'selected' => ($this->getCountryId() == $country->getCountryId()) ? true : false,
        	];
        }
        
        return $countryOptions;
    }
    
    /**
     * @return int $countryId
     */
    public function getCountryId()
    {
    	return $this->countryId;
    }
    
    /**
     * @param int $countryId
     * @return \Shop\Form\Element\CountryList
     */
    public function setCountryId($countryId)
    {
    	$this->countryId = (int) $countryId;
    	return $this;
    }

}
