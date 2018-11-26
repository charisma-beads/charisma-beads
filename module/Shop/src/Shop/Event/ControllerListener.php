<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Event;

use Shop\Controller\CountryProvinceController;
use Shop\Controller\CustomerAddressController;
use Shop\Controller\ProductOptionController;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

class ControllerListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            CustomerAddressController::class,
            CountryProvinceController::class,
            ProductOptionController::class,
        ], ['add.action'], [$this, 'addAction']);
    }

    public function addAction(Event $e)
    {
        $controller = $e->getTarget();
        $params = $controller->params()->fromRoute('id', null);
        $form = $e->getParam('form');

        switch (get_class($controller)) {
            case CustomerAddressController::class:
                $form->get('customerId')->setValue($params);
                break;
            case CountryProvinceController::class:
                $form->get('countryId')->setValue($params);
                break;
            case ProductOptionController::class:
                $form->get('productId')->setValue($params);
                break;
        }
    }
}
