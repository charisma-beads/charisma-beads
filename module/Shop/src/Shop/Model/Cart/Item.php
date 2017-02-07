<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model\Cart;

use Shop\Model\Order\LineInterface;
use Shop\Model\Order\LineTrait;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;

/**
 * Class Item
 *
 * @package Shop\Model\Cart
 */
class Item implements ModelInterface, LineInterface
{   
    use Model,
        LineTrait;
	
	/**
	 * @return number
	 */
    public function getCartItemId()
    {
        return $this->getId();
    }

    /**
     * @param $cartItemId
     * @return $this
     */
    public function setCartItemId($cartItemId)
    {
        $this->setId($cartItemId);
        return $this;
    }

    /**
     * @return int
     */
    public function getCartId()
    {
        return $this->getParentId();
    }

    /**
     * @param $cartId
     * @return $this
     */
    public function setCartId($cartId)
    {
        $this->setParentId($cartId);
        return $this;
    }
}
