<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Model;


/**
 * Interface LineInterface
 * @package Shop\Model
 */
interface OrderLineInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getParentId();

    /**
     * @param int $parentId
     * @return $this
     */
    public function setParentId($parentId);

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
     * @return float
     */
    public function getTax();

    /**
     * @param float $tax
     * @return $this
     */
    public function setTax($tax);

    /**
     * @return ProductMetaDataModel
     */
    public function getMetadata();

    /**
     * @param ProductMetaDataModel $metadata
     * @return $this
     */
    public function setMetadata(ProductMetaDataModel $metadata);
}
