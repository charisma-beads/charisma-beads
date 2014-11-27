<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class CountryProvinceList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a province---';
    
    /**
     * @var int
     */
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
    	return ($this->valueOptions) ?: $this->getProvinces();
    }
    
    public function getProvinces()
    {
        $service = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Shop\Service\Country\Province');
        
        if ($this->getCountryId()) {
            $provinces = $service->getProvincesByCountryId($this->getCountryId());
        } else {
            $provinces = $service->fetchAll();
        }
        
        $provinceOptions = [];
         
        foreach($provinces as $province) {
        	$provinceOptions[$province->getProvinceId()] = $province->getProvinceName();
        }
        
        return $provinceOptions;
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
	 * @return \Shop\Form\Element\CountryProvinceList
	 */
	public function setCountryId($countryId)
	{
		$this->countryId = (int) $countryId;
		return $this;
	}
}
