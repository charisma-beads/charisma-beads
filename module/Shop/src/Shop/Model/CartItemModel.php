<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;


use Common\Model\ModelInterface;
use Common\Model\Model;

/**
 * Class Item
 *
 * @package Shop\Model
 */
class CartItemModel implements ModelInterface, OrderLineInterface
{   
    use Model,
        OrderLineTrait;
	
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
