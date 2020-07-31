<?php

namespace Shop\Form\Element;

use Shop\Service\ProductGroupService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ProductGroupList
 *
 * @package Shop\Form\Element
 */
class ProductGroupList extends Select implements ServiceLocatorAwareInterface
{ 
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $groups = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(ProductGroupService::class)
            ->fetchAll();
        
        $groupOptions = ['0' => 'None'];
    	
    	/* @var $group \Shop\Model\ProductGroupModel */
    	foreach($groups as $group) {
    		$groupOptions[$group->getProductGroupId()] = $group->getGroup() . ' - ' . $group->getPrice();
    	}
        
        $this->setValueOptions($groupOptions);
    }

}
