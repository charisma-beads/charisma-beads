<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Event;

use Shop\Options\ShopOptions;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;

/**
 * Class SiteMapListener
 *
 * @package Shop\Event
 */
class ErrorListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach([
            MvcEvent::EVENT_RENDER_ERROR,
            MvcEvent::EVENT_DISPATCH_ERROR
        ], [$this, 'mailError']);
    }

    /**
     * @param MvcEvent $e
     */
    public function mailError(MvcEvent $e)
    {
        $services  = $e->getApplication()->getServiceManager();
        $exception = $e->getResult()->exception;

        /** @var \Shop\Options\ShopOptions $shopOptions */
        $shopOptions = $services->get(ShopOptions::class);

        if (!$e->isError() || !$exception || $shopOptions->isDevelopmentMode()) {
            return;
        }

        $errorService = $services->get('ExceptionMailer\ErrorHandling');
        $errorService->mailException($exception);
    }
}
