<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   Shop\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Event;

use Shop\Model\Order\AbstractOrderCollection;
use Shop\Model\Order\LineInterface;
use Shop\Model\Product\Product as ProductModel;
use Shop\Service\Cart\Cart;
use Shop\Service\Order\Order;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Class StockControl
 *
 * @package Shop\Service
 */
class StockControlListener implements ListenerAggregateInterface
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
            ['cart.stock.check'],
            [$this, 'cartCheck']
        );

        $this->listeners[] = $events->attach(
            [Cart::class, Order::class],
            ['stock.check'],
            [$this, 'check']
        );

        $this->listeners[] = $events->attach(
            [Cart::class, Order::class],
            ['stock.save'],
            [$this, 'save']
        );

        $this->listeners[] = $events->attach(
            [Cart::class, Order::class],
            ['stock.restore'],
            [$this, 'restore']
        );

        $this->listeners[] = $events->attach(
            [Cart::class, Order::class],
            ['stock.restore.one'],
            [$this, 'restoreStockFromOne']
        );

        $this->listeners[] = $events->attach(
            [Cart::class, Order::class],
            ['stock.restore.many'],
            [$this, 'restoreStockFromMany']
        );
    }

    /**
     * Check if cart has more than whats in stock
     *
     * @param Event $e
     */
    public function cartCheck(Event $e)
    {
        /* @var $line LineInterface */
        $line       = $e->getParam('line');
        /* @var $product ProductModel */
        $product    = $e->getParam('product');
        $qty        = $e->getParam('qty');

        $currentCartQuantity = $line->getQuantity();

        // calculate the difference that's in the cart and what is asked for.
        $diff = ($currentCartQuantity < $qty) ? ($qty - $currentCartQuantity) : ($currentCartQuantity - $qty);



        // if product is non stock item return
        if ($product->getQuantity() < 0) {
            return;
        }

        // if quantity is greater than zero then
        // set quantity according to stock availability
        if ($currentCartQuantity <= $qty) {

            // if request is more than we have in stock, only allow what is in stock
            if ($product->getQuantity() < $qty) {
                $qty = $product->getQuantity();
                $e->setParam('message', sprintf(
                    'You asked for %s x %s, only %s are available. Your request has been reduced by %s',
                    $qty + $diff,
                    $product->getSku(),
                    $product->getQuantity(),
                    $diff
                ));
            }
        }

        // reduce the cart quantity
        if ($currentCartQuantity > $qty) {
            $qty = $currentCartQuantity - $diff;
        }

        // set the adjusted params
        $e->setParam('qty', $qty);
    }

    /**
     * Check if product is out of stock
     *
     * @param Event $e
     */
    public function check(Event $e)
    {
        /* @var $line LineInterface */
        $line       = $e->getParam('line');
        /* @var $product ProductModel */
        $product    = $e->getParam('product');
        $qty        = $e->getParam('qty');

        $currentQuantity = $line->getQuantity();

        // calculate the difference that's in the order and what is asked for.
        $diff = ($currentQuantity < $qty) ? ($qty - $currentQuantity) : ($currentQuantity - $qty);

        // if product is non stock item return
        if ($product->getQuantity() < 0) {
            return;
        }

        // if quantity is greater than zero then
        // set quantity according to stock availability
        // and update product quantity
        if ($currentQuantity < $qty) {
            // if request is more than we have in stock, only allow what is in stock
            if ($product->getQuantity() < $diff) {
                $diff = $product->getQuantity();
                $qty = $currentQuantity + $diff;
            }

            $product->setQuantity($product->getQuantity() - $diff);
        }

        // if we reduce the order quantity, then put excess back into stock
        if ($currentQuantity > $qty) {
            $qty = $currentQuantity - $diff;
            $product->setQuantity($product->getQuantity() + $diff);
        }

        // set the adjusted params
        $e->setParam('qty', $qty);
        $e->setParam('product', $product);
    }

    /**
     * Put back any unwanted quantities of a product
     *
     * @param Event $e
     * @param null|AbstractOrderCollection $item
     */
    public function restore(Event $e, $item = null)
    {
        $item = ($item) ?: $e->getParam('item');
        /* @var $product ProductModel */
        $product = $e->getTarget()
            ->getService('ShopProduct')
            ->getById(
                $item->getMetadata()->getProductId()
            );

        // restore stock items and ignore the rest
        if ($product->getQuantity() >= 0) {
            $product->setQuantity(
                $product->getQuantity() + $item->getQuantity()
            );
            $e->getTarget()
                ->getService('ShopProduct')
                ->save($product);
        }
    }

    /**
     * restore unwanted product quantities from one model.
     *
     * @param Event $e
     */
    public function restoreStockFromOne(Event $e)
    {
        $model = $e->getParam('model');
        $this->process($e, $model);
    }

    /**
     * @param Event $e
     */
    public function save(Event $e)
    {
        $product = $e->getParam('product');
        $e->getTarget()
            ->getService('ShopProduct')
            ->save($product);
    }

    /**
     * Restore unwanted product quantities from many models
     *
     * @param Event $e
     */
    public function restoreStockFromMany(Event $e)
    {
        $models = $e->getParam('models');
        $ids = [];

        /* @var $model AbstractOrderCollection */
        foreach ($models as $model) {
            $ids[] = $model->getId();
            $this->process($e, $model);
        }

        $e->setParam('ids', $ids);
    }

    /**
     * @param Event $e
     * @param AbstractOrderCollection $model
     */
    public function process(Event $e, AbstractOrderCollection $model)
    {
        foreach ($model as $item) {
            $this->restore($e, $item);
        }
    }
} 