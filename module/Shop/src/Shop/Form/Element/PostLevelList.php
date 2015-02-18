<?php
namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class PostLevelList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a level---';
    
    public function init()
    {
        $postLevels = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopPostLevel')
            ->fetchAll();
        
        $postLevelOptions = [];
		
		/* @var $level \Shop\Model\Post\Level */
		foreach($postLevels as $level) {
			$postLevelOptions[$level->getPostLevelId()] = $level->getPostLevel();
		}
        
        $this->setValueOptions($postLevelOptions);
    }

}
