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
 * Class OrderStatusList
 *
 * @package Shop\Form\Element
 */
class OrderStatusList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $statuses = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get('ShopOrderStatus')
            ->fetchAll();
        
    	$statusOptions = [];
    	
    	/* @var $status \Shop\Model\Order\Status */
    	foreach($statuses as $status) {
    		$statusOptions[$status->getOrderStatusId()] = $status->getOrderStatus();
    	}

        $this->setValueOptions($statusOptions);
    }
}
