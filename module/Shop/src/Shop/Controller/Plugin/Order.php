<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Plugin
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;

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
