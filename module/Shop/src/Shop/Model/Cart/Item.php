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
     * @var int
     */
    protected $cartItemId;
    
    /**
     * @var int
     */
    protected $cartId;
	
	/**
	 * @return number
	 */
    public function getCartItemId()
    {
        return $this->cartItemId;
    }

    /**
     * @param $cartItemId
     * @return $this
     */
    public function setCartItemId($cartItemId)
    {
        $this->cartItemId = $cartItemId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param $cartId
     * @return $this
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }
}
