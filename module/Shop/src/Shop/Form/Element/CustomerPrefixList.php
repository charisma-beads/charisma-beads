<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class CustomerPrefixList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a prefix---';
    
    public function init()
    {
        $prefixes = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Shop\Service\Customer\Prefix')
            ->fetchAll();
        
    	$prefixOptions = [];
    	
    	/* @var $prefix \Shop\Model\Customer\Prefix */
    	foreach($prefixes as $prefix) {
    		$prefixOptions[$prefix->getPrefixId()] = $prefix->getPrefix();
    	}
        
        $this->setValueOptions($prefixOptions);
    }

}
