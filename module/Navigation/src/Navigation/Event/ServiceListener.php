<?php

namespace Navigation\Event;

use Navigation\Service\MenuItemService;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;


class ServiceListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            MenuItemService::class
        ], ['form.init'], [$this, 'menuItemForm']);
    }

    public function menuItemForm(Event $e)
    {
        $data  = $e->getParam('data');
        $model = $e->getParam('model');
        $form = $e->getParam('form');

        if (isset($data['menuId'])) {
            $menuId = $data['menuId'];
        } elseif ($model) {
            $menuId = $model->getMenuId();
        } elseif ($form) {
            $menuId = $form->get('menuId')->getValue();
        }

        if (isset($menuId)) {
            $form->get('position')->setMenuId($menuId);
        }
    }
}
