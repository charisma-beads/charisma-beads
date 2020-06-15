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

use Shop\Service\CountryProvinceService;
use Common\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class CountryProvinceList
 *
 * @package Shop\Form\Element
 */
class CountryProvinceList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a province---';
    
    /**
     * @var int
     */
    protected $countryId = 1;
    
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
            ->get(ServiceManager::class)
            ->get(CountryProvinceService::class);

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
