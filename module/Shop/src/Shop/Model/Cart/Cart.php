<?php
namespace Shop\Model\Cart;

use UthandoCommon\Model\Collection;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class Cart extends Collection implements
    \Iterator,
    \Countable,
    \ArrayAccess,
    \SeekableIterator,
    ModelInterface
{
    use Model,
        DateModifiedTrait;
    
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
    
    public function __construct()
    {
        $this->setEntityClass('Shop\Model\Cart\Item');
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
