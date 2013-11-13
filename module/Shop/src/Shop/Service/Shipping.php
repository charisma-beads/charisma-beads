<?php
namespace Shop\Service;

class Shipping
{
    protected $countryService;
    
    protected $countryCode;
    
    protected $postWeight;
    
    /**
     * @return \Shop\Service\Country $countryService
     */
    public function getCountryService()
    {
    	return $this->countryService;
    }
    
    /**
     * @param \Shop\Service\Country $countryervice
     */
    public function setCountryService($countryService)
    {
    	$this->countryService = $countryService;
    	return $this;
    }
}
