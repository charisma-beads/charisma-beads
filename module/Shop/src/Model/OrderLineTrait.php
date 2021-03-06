<?php

namespace Shop\Model;


/**
 * Class LineTrait
 *
 * @package Shop\Model
 */
trait OrderLineTrait
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $parentId;

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
     * @var ProductMetaDataModel
     */
    protected $metadata;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     * @return $this
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

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
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
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
     * @return ProductMetaDataModel
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param ProductMetaDataModel $metadata
     * @return $this
     */
    public function setMetadata(ProductMetaDataModel $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
