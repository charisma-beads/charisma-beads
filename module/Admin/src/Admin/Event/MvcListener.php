<?php
namespace Admin\Event;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class MvcListener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    
    public function onDispatch(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();
        $config = $sm->get('config');
        
        $match = $event->getRouteMatch();
        $controller = $event->getTarget();
        
        if (!$match instanceof RouteMatch || false === strpos($match->getMatchedRouteName(), 'admin') || $controller->getEvent()->getResult()->terminate()) {
            return;
        }
        
        $layout = $config['admin']['admin_layout_template'];
        $controller->layout($layout); 
    }
}
