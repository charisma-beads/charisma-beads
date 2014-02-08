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
    protected $dateCreated;
    
    /**
     * Total before shipping
     *
     * @var float
     */
    protected $subTotal = 0;
    
    /**
     * Total with shipping
     *
     * @var float
     */
    protected $total = 0;
    
    /**
     * The shipping cost
     *
     * @var float
     */
    protected $shipping = 0;
    
    /**
     * Total of tax
     *
     * @var float
     */
    protected $taxTotal = 0;
    
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
	public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param DateTime $dateCreated
     * @return \Shop\Model\Cart
     */
	public function setDateCreated(DateTime $dateCreated = null)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return float
     */
	public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @param float $subTotal
     * @return \Shop\Model\Cart
     */
	public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;
        return $this;
    }

    /**
     * @return number
     */
	public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return \Shop\Model\Cart
     */
	public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return number
     */
	public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param float $shipping
     * @return \Shop\Model\Cart
     */
	public function setShipping($shipping)
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * @return number
     */
	public function getTaxTotal()
    {
        return $this->taxTotal;
    }

    /**
     * @param float $taxTotal
     * @return \Shop\Model\Cart
     */
	public function setTaxTotal($taxTotal)
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }
}
