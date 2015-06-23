<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   Shop\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Model\Cart\Cart;
use Shop\Model\Cart\Item as CartItem;
use Shop\Model\Order\Line;
use Shop\Model\Order\Order;
use Shop\Model\Product\Product as ProductModel;
use Shop\Service\Product\Product;
use UthandoCommon\Service\ServiceException;
use Zend\EventManager\Event;

/**
 * Class StockControl
 * @package Shop\Service
 */
class StockControl
{
    /**
     * @var Product
     */
    protected $productService;

    /**
     * @var Event
     */
    protected $event;

    /**
     * Set up the events to listen for
     *
     * @param Event $e
     */
    public function init(Event $e)
    {
        $this->productService = $e->getTarget()
            ->getService('ShopProduct');

        $this->event = $e;
        $event = $e->getName();

        switch ($event) {
            case 'stock.check':
                $this->check();
                break;
            case 'stock.save':
                $this->save($this->event->getParam('product'));
                break;
            case 'stock.restore':
                $this->restore($this->event->getParam('item'));
                break;
            case 'stock.restore.one':
                $this->restoreStockFromOne($this->event->getParam('model'));
                break;
            case 'stock.restore.many':
                $this->restoreStockFromMany($this->event->getParam('models'));
                break;
        }
    }

    /**
     * Check if product is out of stock
     *
     * @internal param Event $e
     */
    public function check()
    {
        /* @var $item CartItem|Line */
        $item = $this->event->getParam('item');
        /* @var $product ProductModel */
        $product = $this->event->getParam('product');
        $qty     = $this->event->getParam('qty');

        $currentCartQuantity = $item->getQuantity();
        // calculate the difference that's in the cart and what is asked for.
        $diff = ($currentCartQuantity < $qty) ? ($qty - $currentCartQuantity) : ($currentCartQuantity - $qty);

        // if product is non stock item return
        if ($product->getQuantity() < 0) {
            return;
        }

        // if quantity is greater than zero then
        // set quantity according to stock availability
        // and update product quantity
        if ($currentCartQuantity < $qty) {
            // if request is more than we have in stock, only allow what is in stock
            if ($product->getQuantity() < $diff) {
                $diff = $product->getQuantity();
                $qty = $currentCartQuantity + $diff;
            }

            $product->setQuantity($product->getQuantity() - $diff);
        }

        // if we reduce the cart quantity, then put excess back into stock
        if ($currentCartQuantity > $qty) {
            $qty = $currentCartQuantity - $diff;
            $product->setQuantity($product->getQuantity() + $diff);
        }

        // set the adjusted params
        $this->event->setParam('qty', $qty);
        $this->event->setParam('product', $product);
    }

    /**
     * Put back any unwanted quantities of a product
     *
     * @param CartItem|Line $item
     * @throws ServiceException
     */
    public function restore($item)
    {
        /* @var $product ProductModel */
        $product = $this->productService->getById(
            $item->getMetadata()->getProductId()
        );

        // restore stock items and ignore the rest
        if ($product->getQuantity() >= 0) {
            $product->setQuantity(
                $product->getQuantity() + $item->getQuantity()
            );
            $this->productService->save($product);
        }
    }

    /**
     * restore unwanted product quantities from one model.
     *
     * @param $model
     */
    public function restoreStockFromOne($model)
    {
        $this->processCart($model);
    }

    /**
     * @param $product
     * @throws ServiceException
     */
    public function save($product)
    {
        $this->productService->save($product);
    }

    /**
     * Restore unwanted product quantities from many models
     *
     * @param array $models
     */
    public function restoreStockFromMany($models)
    {
        $ids = [];

        /* @var $model Cart|Line */
        foreach ($models as $model) {
            $ids[] = $model->getId();
            $this->process($model);
        }

        $this->event->setParam('ids', $ids);
    }

    /**
     * @param Cart|Order $model
     * @throws ServiceException
     */
    public function process($model)
    {
        /* @var $item CartItem|Line */
        foreach ($model as $item) {
            $this->restore($item);
        }
    }
} 