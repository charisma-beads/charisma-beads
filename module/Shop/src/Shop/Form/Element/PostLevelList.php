<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use UthandoCommon\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

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
