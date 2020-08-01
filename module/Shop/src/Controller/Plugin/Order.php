<?php

namespace Shop\Controller\Plugin;

use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use Laminas\Session\Container;

/**
 * Class Order
 *
 * @package Shop\Controller\Plugin
 */
class Order extends AbstractPlugin
{
    /**
     * @var Container
     */
    protected $container;
    
    /**
     *
     * @return array
     */
    public function getOrderFromSession()
    {
    	if (! $this->container instanceof Container) {
    		$this->container = new Container('order');
    	}
    
    	return $this->container->order;
    }
}
