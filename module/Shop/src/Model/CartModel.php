<?php

namespace Shop\Model;

use Common\Model\DateModifiedTrait;

/**
 * Class Cart
 *
 * @package Shop\Model
 */
class CartModel extends AbstractOrderCollection
{
    use DateModifiedTrait;

    protected $entityClass = CartItemModel::class;
    
    /**
     * @var int
     */
    protected $cartId;
    
    /**
     * @var string
     */
    protected $verifyId;
    
    /**
     * @var int
     */
    protected $expires;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getCartId();
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total - $this->discount;
    }

    /**
     * Return cart item by its id
     *
     * @param $id
     * @return bool|CartItemModel
     */
    public function getCartItemById($id)
    {
        /* @var $cartItem CartItemModel */
        foreach ($this->getEntities() as $cartItem) {
            if ($cartItem->getCartItemId() == $id) {
                return $cartItem;
            }
        }

        return false;
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

    /**
     * @return string
     */
    public function getVerifyId()
    {
        return $this->verifyId;
    }

    /**
     * @param $verifyId
     * @return $this
     */
    public function setVerifyId($verifyId)
    {
        $this->verifyId = $verifyId;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param $expires
     * @return $this
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
        return $this;
    }
}
