<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ProductGroupList extends Select implements ServiceLocatorAwareInterface
{ 
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $groups = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopProductGroup')
            ->fetchAll();
        
        $groupOptions = ['0' => 'None'];
    	
    	/* @var $group \Shop\Model\Product\Group */
    	foreach($groups as $group) {
    		$groupOptions[$group->getProductGroupId()] = $group->getGroup() . ' - ' . $group->getPrice();
    	}
        
        $this->setValueOptions($groupOptions);
    }

}
