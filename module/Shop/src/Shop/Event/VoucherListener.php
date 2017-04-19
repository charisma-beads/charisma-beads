<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Event;

use Shop\Service\Cart\Cart;
use Shop\Service\Order\AbstractOrder;
use Shop\Service\Order\Order;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Class VoucherListener
 *
 * @package Shop\Event
 */
class VoucherListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach(
            [Cart::class, Order::class],
            ['voucher.check'],
            [$this, 'check']
        );
    }

    /**
     * @param Event $e
     */
    public function check(Event $e)
    {
        \ChromePhp::info(__METHOD__);

    }
}