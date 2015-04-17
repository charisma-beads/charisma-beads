<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class PostUnitList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a weight---';
    
    public function init()
    {
        $postUnits = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopPostUnit')
            ->fetchAll();
        
    	$postUnitOptions = array();
    	
    	/* @var $postUnit \Shop\Model\Post\Unit */
    	foreach($postUnits as $postUnit) {
    		$postUnitOptions[$postUnit->getPostUnitId()] = $postUnit->getPostUnit();
    	}
        
        $this->setValueOptions($postUnitOptions);
    }

}
