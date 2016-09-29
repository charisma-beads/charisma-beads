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

use Shop\Model\Product\Product;
use Shop\ShopException;
use UthandoCommon\Model\AbstractCollection;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

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
     * @var string
     */
    protected $sortOrder;

    /**
     * @var bool
     */
    protected $autoIncrement = false;

    /**
     * @return int
     */
    abstract public function getId();

    public function addItem(Product $product, $qty)
    {
        if ($qty <= 0 || $product->inStock() === false || $product->isDiscontinued() === true || $product->isEnabled() === false) {
            return false;
        }

        $productClone = clone $product;

        $productId = $productClone->getProductId();
        $optionId = (isset($post['ProductOptionList'])) ? (int) substr(strrchr($post['ProductOptionList'], "-"), 1) : null;

        $productOption = ($optionId) ? $product->getProductOption($optionId) : null;

        if ($productOption instanceof ProductOption) {
            $productClone->setPostUnitId($productOption->getPostUnitId())
                ->setPostUnit($productOption->getPostUnit())
                ->setPrice($productOption->getPrice(false))
                ->setDiscountPercent($productOption->getDiscountPercent());
            $productId = $productId . '-' . $optionId;
        }

        /** @var $item CartItem */
        $item = ($this->offsetExists($productId)) ? $this->offsetGet($productId) : new $this->entityClass();

        if ($this->isAutoIncrementCart()) {
            $qty = $qty + $item->getQuantity();
        }
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
        return $this->total;
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
     * @return boolean
     */
    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * @param boolean $autoIncrement
     * @return $this
     */
    public function setAutoIncrement($autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
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
