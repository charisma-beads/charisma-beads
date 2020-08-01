<?php

namespace Shop\Form\Element;

use Shop\Service\CustomerPrefixService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class CustomerPrefixList
 *
 * @package Shop\Form\Element
 */
class CustomerPrefixList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a prefix---';
    
    public function init()
    {
        $prefixes = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(CustomerPrefixService::class)
            ->fetchAll();
        
    	$prefixOptions = [];
    	
    	/* @var $prefix \Shop\Model\CustomerPrefixModel */
    	foreach($prefixes as $prefix) {
    		$prefixOptions[$prefix->getPrefixId()] = $prefix->getPrefix();
    	}
        
        $this->setValueOptions($prefixOptions);
    }

}
