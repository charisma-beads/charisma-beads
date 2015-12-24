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

use Shop\ShopException;
use UthandoCommon\Model\AbstractCollection;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class Cart
 *
 * @package Shop\Model\Cart
 */
class Cart extends AbstractCollection implements ModelInterface
{
    use Model,
        DateModifiedTrait;

    protected $entityClass = 'Shop\Model\Cart\Item';
    
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
     * @var bool
     */
    protected $sorted = false;

    /**
     * @var string
     */
    protected $sortOrder;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getCartId();
    }

    /**
     * Return cart item by its id
     *
     * @param $id
     * @return bool|Item
     */
    public function getCartItemById($id)
    {
        /* @var $cartItem \Shop\Model\Cart\Item */
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

    /**
     * @return boolean
     */
    public function isSorted()
    {
        return $this->sorted;
    }

    /**
     * set the sorted value to true.
     */
    protected function setSorted()
    {
        $this->sorted = true;
    }

    /**
     * @return string
     * @throws ShopException
     */
    public function getSortOrder()
    {
        if (!$this->sortOrder) {
            throw new ShopException('sort order cannot be empty');
        }

        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * Make sure we have the cart items in the right order
     * reorder the cart by [category - sku]
     */
    public function rewind()
    {
        if (!$this->isSorted()) {

            $entities = $this->getEntities();
            $keyArray = [];
            $itemArray = [];
            $catArray = [];
            $skuArray = [];

            /* @var $item \Shop\Model\Cart\Item */
            foreach ($entities as $key => $item) {
                $keyArray[] = $key;
                $itemArray[] = $item;
                $catArray[] = $item->getMetadata()->getCategory()->getLft();
                $skuArray[] = $item->getMetadata()->getSku();
            }

            // natural sort the multidimensional array
            //array_multisort(array_keys($tempArray), SORT_ASC, SORT_NATURAL, $tempArray);

            array_multisort($catArray, $skuArray, $keyArray, $itemArray);

            $this->entities = [];

            foreach ($itemArray as $key => $item) {
                $this->entities[$keyArray[$key]] = $item;
            }

            $this->setSorted();
        }

        parent::rewind();
    }

    /**
     * @return int
     */
    public function count()
    {
        $numItems = null;

        /* @var $item Item */
        foreach ($this->entities as $item) {
            $numItems += $item->getQuantity();
        }

        return $numItems;
    }
}
