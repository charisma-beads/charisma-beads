<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Model\Order;

use Shop\ShopException;
use UthandoCommon\Model\AbstractCollection;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class AbstractOrderCollection
 *
 * @package Shop\Model\Order
 */
abstract class AbstractOrderCollection extends AbstractCollection implements ModelInterface
{
    use Model;

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
     * Total shipping tax
     *
     * @var float
     */
    protected $shippingTax = 0;

    /**
     * Total of tax
     *
     * @var float
     */
    protected $taxTotal = 0;

    /**
     * @var bool
     */
    protected $sorted = false;

    /**
     * @var bool
     */
    protected $autoIncrementQuantity = false;

    /**
     * @var float
     */
    protected $discount = 0;

    /**
     * @return int
     */
    abstract public function getId();

    /**
     * Return line item by its id
     *
     * @param $id
     * @return bool|LineInterface
     */
    public function getLineById($id)
    {
        /* @var $orderLine LineInterface */
        foreach ($this->getEntities() as $orderLine) {
            if ($orderLine->getId() == $id) {
                return $orderLine;
            }
        }

        return false;
    }

    /**
     * @return float
     */
    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

    /**
     * @param float $subTotal
     * @return $this
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total - $this->discount;
    }

    /**
     * @param float $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return float
     */
    public function getShipping(): float
    {
        return $this->shipping;
    }

    /**
     * @param float $shipping
     * @return $this
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * @return float
     */
    public function getShippingTax(): float
    {
        return $this->shippingTax;
    }

    /**
     * @param float $shippingTax
     * @return $this
     */
    public function setShippingTax($shippingTax)
    {
        $this->shippingTax = $shippingTax;
        return $this;
    }

    /**
     * @return float
     */
    public function getTaxTotal(): float
    {
        return $this->taxTotal;
    }

    /**
     * @param float $taxTotal
     * @return $this
     */
    public function setTaxTotal($taxTotal)
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return $this
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoIncrementQuantity(): bool
    {
        return $this->autoIncrementQuantity;
    }

    /**
     * @param boolean $autoIncrementQuantity
     * @return $this
     */
    public function setAutoIncrementQuantity($autoIncrementQuantity)
    {
        $this->autoIncrementQuantity = $autoIncrementQuantity;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSorted(): bool
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
    public function getSortOrder(): string
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

            /* @var $item LineInterface */
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

        /* @var $item LineInterface */
        foreach ($this->entities as $item) {
            $numItems += $item->getQuantity();
        }

        return $numItems;
    }
}
