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
use Shop\Model\Cart\Item;
use Shop\Model\Product\Product;
use Zend\EventManager\Event;

/**
 * Class StockControl
 * @package Shop\Service
 */
class StockControl
{
    /**
     * Check if product is out of stock
     *
     * @param Event $e
     */
    public function check(Event $e)
    {
        /* @var $cartItem Item */
        $cartItem = $e->getParam('cartItem');
        /* @var $product Product */
        $product = $e->getParam('product');
        $qty     = $e->getParam('qty');

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
        $e->setParam('qty', $qty);
        $e->setParam('product', $product);

        // update levels in database.
        /* @var $productService \Shop\Service\Product\Product */
        $productService = $e->getTarget()->getService('Shop\Service\Product');

        $productService->save($product);
    }

    /**
     * Restore unwanted product quantities
     *
     * @param Event $e
     */
    public function restore(Event $e)
    {
        $ids = $e->getParam('ids');
        $carts = $e->getParam('carts');
        /* @var $productService \Shop\Service\Product\Product */
        $productService = $e->getTarget()->getService('Shop\Service\Product');

        /* @var $cart Cart */
        foreach ($carts as $cart) {
            $ids[] = $cart->getCartId();

            /* @var $item Item */
            foreach ($cart as $item) {
                /* @var $product Product */
                $product = $productService->getById(
                    $item->getMetadata()->getProductId()
                );

                // restore stock items and ignore the rest
                if ($product->getQuantity() >= 0) {
                    $product->setQuantity(
                        $product->getQuantity() + $item->getQuantity()
                    );
                    $productService->save($product);
                }
            }
        }

        $e->setParam('ids', $ids);
    }
} 