<?php

namespace Shop\Form\Element;

use Shop\Service\PostLevelService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class PostLevelList
 *
 * @package Shop\Form\Element
 */
class PostLevelList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a level---';
    
    public function init()
    {
        $postLevels = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(PostLevelService::class)
            ->fetchAll();
        
        $postLevelOptions = [];
		
		/* @var $level \Shop\Model\PostLevelModel */
		foreach($postLevels as $level) {
			$postLevelOptions[$level->getPostLevelId()] = $level->getPostLevel();
		}
        
        $this->setValueOptions($postLevelOptions);
    }

}
