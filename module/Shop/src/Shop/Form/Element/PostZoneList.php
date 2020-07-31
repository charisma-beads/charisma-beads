<?php

namespace Shop\Form\Element;

use Shop\Service\PostZoneService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class PostZoneList
 *
 * @package Shop\Form\Element
 */
class PostZoneList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a post zone---';

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (array_key_exists('empty_option', $options)) {
            $this->setEmptyOption($options['empty_option']);
        }
    }
    
    public function init()
    {
        $zones = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(PostZoneService::class)
            ->fetchAll();
        
        $zoneOptions = [];
		 
		/* @var $zone \Shop\Model\PostZoneModel */
		foreach($zones as $zone) {
			$zoneOptions[$zone->getPostZoneId()] = $zone->getZone();
		}
        
        $this->setValueOptions($zoneOptions);
    }

}
