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

use Shop\Model\Voucher\Code;
use Shop\Service\Cart\Cart;
use Shop\Service\Order\Order;
use Shop\Service\Voucher\CustomerMap;
use Shop\Validator\Voucher;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

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
            [Cart::class],
            ['voucher.add'],
            [$this, 'cartVoucher']
        );

        $this->listeners[] = $events->attach(
            [Order::class],
            ['voucher.use'],
            [$this, 'useVoucher']
        );
    }

    /**
     * @param Event $e
     */
    public function useVoucher(Event $e)
    {
        /* @var $voucher Code */
        $voucher = $e->getParam('voucher');
        /* @var $order \Shop\Model\Order\Order */
        $order = $e->getParam('order');

        /* @var $voucherService \Shop\Service\Voucher\Code */
        $voucherService = $e->getTarget()->getService('ShopVoucherCode');

        $voucherService->updateVoucherCount($voucher->getCode());

        if ($voucher->getNoPerCustomer() > 0) {
            /* @var $voucherMapService CustomerMap */
            $voucherMapService = $e->getTarget()->getService('ShopVoucherCustomerMap');
            $voucherMapService->updateCustomerCount($voucher, $order->getCustomer());
        }
    }

    /**
     * @param Event $e
     */
    public function cartVoucher(Event $e)
    {
        /* @var Cart $service */
        $service = $e->getTarget();
        $voucher = $service->getContainer()->offsetGet('voucher');

        if (!$voucher) {
            return;
        }

        /* @var Voucher $voucherValidator */
        $voucherValidator = $service->getServiceLocator()
            ->get('ValidatorManager')
            ->get(Voucher::class);

        $voucherValidator->setCart($service->getCart());

        if (!$voucherValidator->isValid($voucher)) {
            $flashMessenger = new FlashMessenger();

            foreach ($voucherValidator->getMessages() as $message) {
                $flashMessenger->addErrorMessage($message);
            }

            $service->getContainer()->offsetSet('voucher', null);

            return;
        }

        $voucher = $voucherValidator->getVoucher($voucher);

        $discount = $e->getTarget()
            ->getService('ShopVoucherCode')
            ->doDiscount($voucher, $service);

        $service->getCart()->setDiscount($discount);
    }
}
