<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Country extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Country';
    protected $form = 'Shop\Form\Country';
    protected $inputFilter = 'Shop\InputFilter\Country';
    
    /**
     * @var \Shop\Service\Post\Zone
     */
    protected $PostZoneService;
    
    public function getCountryPostalRates($id)
    {
        $id = (int) $id;
        return $this->getMapper()->getCountryPostalRates($id);
    }
    
    public function search(array $post)
    {
    	$countries = parent::search($post);
    	
    	foreach ($countries as $country) {
    	    $this->populate($country, true);
    	}
    	
    	return $countries;
    }
    
    /**
     * @param \Shop\Model\Country $model
     * @param bool $children
     */
    public function populate($model, $children = false)
    {
        $allChildren = ($children === true) ? true : false;
        $children = (is_array($children)) ? $children : array();
        	
        if ($allChildren || in_array('zone', $children)) {
            $model->setPostZone(
                $this->getPostZoneService()
                    ->getById($model->getPostZoneId())
            );
        }
    }
    
    /**
     * @return \Shop\Service\Post\Zone
     */
    public function getPostZoneService()
    {
        if (!$this->PostZoneService) {
            $sl = $this->getServiceLocator();
            $this->PostZoneService = $sl->get('Shop\Service\PostZone');
        }
    
        return $this->PostZoneService;
    }
}
