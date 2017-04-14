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

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class PostZoneList
 *
 * @package Shop\Form\Element
 */
class PostZoneList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $emptyOption = '---Please select a post zone---';

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (array_key_exists('empty_option', $options)) {
            $this->setEmptyOption($options['empty_option']);
        }
    }
    
    public function init()
    {
        $zones = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('ShopPostZone')
            ->fetchAll();
        
        $zoneOptions = [];
		 
		/* @var $zone \Shop\Model\Post\Zone */
		foreach($zones as $zone) {
			$zoneOptions[$zone->getPostZoneId()] = $zone->getZone();
		}
        
        $this->setValueOptions($zoneOptions);
    }

}
