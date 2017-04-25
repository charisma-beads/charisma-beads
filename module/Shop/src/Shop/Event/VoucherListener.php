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
            ['cart.voucher'],
            [$this, 'cartVoucher']
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

        // qualified items
        $items = [];
        $voucherCategories = $voucher->getProductCategories()->toArray();

        /* @var \Shop\Model\Cart\Item $item */
        foreach ($service->getCart() as $key => $item) {
            if (in_array($item->getMetadata()->getCategory()->getProductCategoryId(), $voucherCategories)) {
                $items[] = $item;
            }
        }

        $discount = 0;

        if (Code::DISCOUNT_SUBTOTAL === $voucher->getDiscountOperation()) {
            $subTotal = $service->getSubTotal();

            if ($voucher->getDiscountAmount() > $subTotal) {
                $discount = $subTotal;
            } else {
                $discount = $voucher->getDiscountAmount();
            }

        } elseif (Code::DISCOUNT_SUBTOTAL_PERCENTAGE === $voucher->getDiscountOperation()) {
            $subTotal = $service->getSubTotal();
            $discount = (($subTotal) / 100) * $voucher->getDiscountAmount();

        } elseif (Code::DISCOUNT_CATEGORY === $voucher->getDiscountOperation()) {
            $catSubTotal = 0;

            foreach ($items as $item) {
                $catSubTotal += $item->getPrice() * $item->getQuantity();
                $discount += $voucher->getDiscountAmount() * $item->getQuantity();
            }

            if ($discount > $catSubTotal) {
                $discount = $catSubTotal;
            }

        } elseif (Code::DISCOUNT_CATEGORY_PERCENTAGE === $voucher->getDiscountOperation()) {
            $catSubTotal = 0;

            foreach ($items as $item) {
                $catSubTotal += $item->getPrice() * $item->getQuantity();
            }

            $discount = (($catSubTotal) / 100) * $voucher->getDiscountAmount();

        } elseif (Code::DISCOUNT_SHIPPING === $voucher->getDiscountOperation()) {
            $shipping = $service->getShippingCost() + $service->getShippingTax();

            if ($voucher->getDiscountAmount() > $shipping) {
                $discount = $shipping;
            } else {
                $discount = $voucher->getDiscountAmount();
            }

        } elseif (Code::DISCOUNT_SHIPPING_PERCENTAGE === $voucher->getDiscountOperation()) {
            $shipping = $service->getShippingCost() + $service->getShippingTax();
            $discount = (($shipping) / 100) * $voucher->getDiscountAmount();
        }

        $service->getCart()->setDiscount($discount);

    }
}
