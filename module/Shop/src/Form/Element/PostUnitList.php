<?php

namespace Shop\Form\Element;

use Shop\Service\PostUnitService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class PostUnitList
 *
 * @package Shop\Form\Element
 */
class PostUnitList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a weight---';
    
    public function init()
    {
        $postUnits = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(PostUnitService::class)
            ->fetchAll('postUnit');
        
    	$postUnitOptions = array();
    	
    	/* @var $postUnit \Shop\Model\PostUnitModel */
    	foreach($postUnits as $postUnit) {
    		$postUnitOptions[$postUnit->getPostUnitId()] = $postUnit->getPostUnit();
    	}
        
        $this->setValueOptions($postUnitOptions);
    }

}
