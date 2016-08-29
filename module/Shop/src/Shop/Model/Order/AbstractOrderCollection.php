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

use Shop\Service\Shipping;
use Shop\Service\Tax\Tax;
use Shop\ShopException;
use UthandoCommon\Model\AbstractCollection;
use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class AbstractOrderCollection extends AbstractCollection implements ModelInterface
{
    use Model;

    /**
     * @var bool
     */
    protected $sorted = false;

    /**
     * @var string
     */
    protected $sortOrder;

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
