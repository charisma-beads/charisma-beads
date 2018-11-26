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

use Shop\Service\PostUnitService;
use UthandoCommon\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

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
