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

use Shop\Model\Product\MetaData as ProductMetaData;

/**
 * Class LineTrait
 *
 * @package Shop\Model\Order
 */
trait LineTrait
{
    /**
     * @var int
     */
    protected $quantity = 0;

    /**
     * @var float
     */
    protected $price = 0.00;

    /**
     * @var float
     */
    protected $tax = 0.00;

    /**
     * @var ProductMetaData
     */
    protected $metadata;

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param bool $formatPercent
     * @return float
     */
    public function getTax($formatPercent=false)
    {
        return (true === $formatPercent) ? $this->tax / 100 : $this->tax;
    }

    /**
     * @param $tax
     * @return $this
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return ProductMetaData
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param ProductMetaData $metadata
     * @return $this
     */
    public function setMetadata(ProductMetaData $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
