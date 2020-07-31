<?php

namespace Shop\Form\Element;

use Shop\Service\CountryService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class CountryList
 *
 * @package Shop\Form\Element
 */
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
        /* @var \Shop\Service\CountryService $countryService */
        $countryService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(CountryService::class);

        $countries = $countryService->fetchAll();
        
        $countryOptions = [];

        if ($this->getCountryId()) {
            $countryId = $this->getCountryId();
        } else {
            $default = $countryService->getCountryByCountryCode('GB');

            $countryId = $default->getCountryId();
        }
         
        foreach($countries as $country) {
        	$countryOptions[] = [
        	   'label' => $country->getCountry(),
        	   'value' => $country->getCountryId(),
        	   'selected' => ($countryId == $country->getCountryId()) ? true : false,
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
