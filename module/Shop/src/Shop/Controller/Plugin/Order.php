<?php
namespace Shop\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;

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
