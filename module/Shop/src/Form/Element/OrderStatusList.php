<?php

namespace Shop\Form\Element;

use Shop\Service\OrderStatusService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

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
            ->get(OrderStatusService::class)
            ->fetchAll();
        
    	$statusOptions = [];
    	
    	/* @var $status \Shop\Model\OrderStatusModel */
    	foreach($statuses as $status) {
    		$statusOptions[$status->getOrderStatusId()] = $status->getOrderStatus();
    	}

        $this->setValueOptions($statusOptions);
    }
}
