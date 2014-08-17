<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ProductGroupPriceList extends Select implements ServiceLocatorAwareInterface
{ 
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $groups = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Shop\Service\Product\GroupPrice')
            ->fetchAll();
        
        $groupPriceOptions = ['0' => 'None'];
    	
    	/* @var $group \Shop\Model\Product\GroupPrice */
    	foreach($groups as $group) {
    		$groupPriceOptions[$group->getProductGroupId()] = $group->getGroup() . ' - ' . $group->getPrice();
    	}
        
        $this->setValueOptions($groupPriceOptions);
    }

}
