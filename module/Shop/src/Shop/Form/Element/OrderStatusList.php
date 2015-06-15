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

class OrderStatusList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $statuses = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
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
