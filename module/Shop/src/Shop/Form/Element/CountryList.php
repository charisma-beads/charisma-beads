<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use UthandoCommon\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

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
        /* @var \Shop\Service\Country\Country $countryService */
        $countryService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get('ShopCountry');

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
