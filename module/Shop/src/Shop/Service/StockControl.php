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
use Shop\Model\Product\Product as ProductModel;
use Shop\Service\Product\Product;
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

    public function init(Event $e)
    {
        $this->productService = $e->getTarget()
            ->getService('Shop\Service\Product');

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
                $this->restore($this->event->getParam('cartItem'));
                break;
            case 'stock.restore.cart':
                $this->restoreStockFromOneCart($this->event->getParam('cart'));
                break;
            case 'stock.restore.carts':
                $this->restoreStockFromManyCarts($this->event->getParam('carts'));
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
        /* @var $cartItem CartItem */
        $cartItem = $this->event->getParam('cartItem');
        /* @var $product ProductModel */
        $product = $this->event->getParam('product');
        $qty     = $this->event->getParam('qty');

        $currentCartQuantity = $cartItem->getQuantity();
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
            // if request is more than we have in stock
            if ($product->getQuantity() < $diff) {
                $diff = $product->getQuantity();
                $qty = $currentCartQuantity + $diff;
            }

            $product->setQuantity($product->getQuantity() - $diff);
        }

        // if we reduce the cart quantity, then put it back into stock
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
     * @param CartItem $item
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function restore(CartItem $item)
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
     * restore unwanted product quantities from one cart.
     * @param $cart
     */
    public function restoreStockFromOneCart($cart)
    {
        $this->processCart($cart);
    }

    /**
     * saves product to database
     *
     * @param Product $product
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function save($product)
    {
        $this->productService->save($product);
    }

    /**
     * Restore unwanted product quantities from many carts
     *
     * @param array $carts
     */
    public function restoreStockFromManyCarts($carts)
    {
        $ids = [];

        /* @var $cart Cart */
        foreach ($carts as $cart) {
            $ids[] = $cart->getCartId();
            $this->processCart($cart);
        }

        $this->event->setParam('ids', $ids);
    }

    /**
     * @param Cart $cart
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function processCart(Cart $cart)
    {
        /* @var $item CartItem */
        foreach ($cart as $item) {
            $this->restore($item);
        }
    }
} 