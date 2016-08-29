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
 * Interface LineInterface
 * @package Shop\Model\Order
 */
interface LineInterface
{
    /**
     * @return int
     */
    public function getQuantity();

    /**
     * @param $quantity
     * @return $this
     */
    public function setQuantity($quantity);

    /**
     * @return float
     */
    public function getPrice();

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price);

    /**
     * @param bool $formatPercent
     * @return float
     */
    public function getTax($formatPercent=false);

    /**
     * @param $tax
     * @return $this
     */
    public function setTax($tax);

    /**
     * @return ProductMetaData
     */
    public function getMetadata();

    /**
     * @param ProductMetaData $metadata
     * @return $this
     */
    public function setMetadata(ProductMetaData $metadata);
}
