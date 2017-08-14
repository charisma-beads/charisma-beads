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
use Shop\Service\Order\AbstractOrder;
use Shop\Service\Order\Order;
use Shop\Service\Voucher\Code as CodeService;
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
            ['cart.voucher.check'],
            [$this, 'cartVoucher']
        );

        $this->listeners[] = $events->attach(
            [Order::class],
            ['voucher.use'],
            [$this, 'useVoucher']
        );

        $this->listeners[] = $events->attach(
            [Order::class],
            ['order.voucher.check'],
            [$this, 'orderVoucher']
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

        if (!$voucher || !$voucher->getVoucherId()) {
            return;
        }

        /* @var $voucherService CodeService */
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
    public function orderVoucher(Event $e)
    {
        /* @var Order $service */
        $service = $e->getTarget();
        $voucher = $service->getOrderModel()
            ->getMetadata()
            ->getVoucher();

        if (!$voucher) {
            return;
        }

        $voucherValidator = $this->getVoucherValidator($e);

        if (!$voucherValidator->isValid($voucher->getCode())) {
            $this->setErrorMessages($voucherValidator);
            $service->getOrderModel()
                ->getMetadata()
                ->setVoucher(new Code());
            $service->getOrderModel()
                ->setDiscount(0);
            return;
        }

        $discount = $this->doDiscount($e, $voucherValidator, $voucher->getCode());
        $service->getOrderModel()->setDiscount($discount);
        $service->getOrderModel()->setTotal(
            $service->getOrderModel()->getTotal() - $discount
        );
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

        $voucherValidator   = $this->getVoucherValidator($e);
        $countryId          = $e->getTarget()->getContainer()->offsetGet('countryId');
        $country            = $service->getService('ShopCountry')->getById($countryId);

        if ($countryId) {
            $voucherValidator->setCountry($country);
        }

        if (!$voucherValidator->isValid($voucher)) {

            $this->setErrorMessages($voucherValidator);
            $service->getContainer()->offsetSet('voucher', null);

            return;
        }

        $discount = $this->doDiscount($e, $voucherValidator, $voucher);

        $service->getCart()->setDiscount($discount);
    }

    /**
     * @param Voucher $voucherValidator
     */
    private function setErrorMessages(Voucher $voucherValidator)
    {
        $flashMessenger = new FlashMessenger();

        foreach ($voucherValidator->getMessages() as $message) {
            $flashMessenger->addMessage($message, 'voucher-error');
        }
    }

    /**
     * @param Event $e
     * @return Voucher
     */
    private function getVoucherValidator(Event $e)
    {
        /* @var Voucher $voucherValidator */
        $voucherValidator = $e->getTarget()->getServiceLocator()
            ->get('ValidatorManager')
            ->get(Voucher::class);

        $voucherValidator->setOrderModel($e->getTarget()->getOrderModel());

        return $voucherValidator;
    }

    /**
     * @param Event $e
     * @param Voucher $voucherValidator
     * @param string $voucherCode
     * @return float|int
     */
    private function doDiscount(Event $e, Voucher $voucherValidator, $voucherCode)
    {
        $voucher = $voucherValidator->getVoucher($voucherCode);
        /* @var AbstractOrder $service */
        $service = $e->getTarget();
        /* @var CodeService $codeService */
        $codeService = $service->getService('ShopVoucherCode');

        $discount = $codeService->doDiscount($voucher, $service);

        return $discount;
    }
}
