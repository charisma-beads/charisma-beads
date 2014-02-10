<?php
namespace Shop\Model;

use ArrayAccess;
use Countable;
use DateTime;
use Iterator;
use SeekableIterator;
use Application\Model\AbstractModel;
use Application\Model\Collection;

class Cart extends AbstractModel implements Iterator, Countable, ArrayAccess, SeekableIterator
{
    use Collection;
    
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
     * @var DateTime
     */
    protected $dateModified;
    
    public function __construct()
    {
        $this->setEntityClass('Shop\Model\Cart\Item');
    }
    
    /**
     * @return number
     */
	public function getCartId()
    {
        return $this->cartId;
    }
    
    /**
     * @param int $cartId
     * @return \Shop\Model\Cart
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
     * @param string $verifyId
     * @return \Shop\Model\Cart
     */
	public function setVerifyId($verifyId)
    {
        $this->verifyId = $verifyId;
        return $this;
    }

    /**
     * @return number
     */
	public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param string $expires
     * @return \Shop\Model\Cart
     */
	public function setExpires($expires)
    {
        $this->expires = $expires;
        return $this;
    }

    /**
     * @return DateTime
     */
	public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param DateTime $dateModified
     * @return \Shop\Model\Cart
     */
	public function setDateModified(DateTime $dateModified = null)
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}
