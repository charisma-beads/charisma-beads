<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class PostZoneList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a post zone---';
    
    public function init()
    {
        $zones = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Shop\Service\Post\Zone')
            ->fetchAll();
        
        $zoneOptions = [];
		 
		/* @var $zone \Shop\Model\Post\Zone */
		foreach($zones as $zone) {
			$zoneOptions[$zone->getPostZoneId()] = $zone->getZone();
		}
        
        $this->setValueOptions($zoneOptions);
    }

}
