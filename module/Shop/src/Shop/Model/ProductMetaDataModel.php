<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class MetaData
 *
 * @package Shop\Model
 */
class ProductMetaDataModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $productId;
    
    /**
     * @var string
     */
    protected $sku;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var float
     */
    protected $postUnit;

    /**
     * @var ProductImageModel
     */
    protected $image;
    
    /**
     * @var ProductCategoryModel
     */
    protected $category;
    
    /**
     * @var string
     */
    protected $description;
    
    /**
     * @var boolean
     */
    protected $taxable;
    
    /**
     * @var boolean
     */
    protected $vatInc;
    
    /**
     * @var boolean
     */
    protected $addPostage;
    
    /**
     * @var bool
     */
    protected $showImage;
    
    /**
     * @var ProductOptionModel
     */
    protected $option;
    
	/**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param $productId
     * @return $this
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return string $sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPostUnit()
    {
        return $this->postUnit;
    }

    /**
     * @param $postUnit
     * @return $this
     */
    public function setPostUnit($postUnit)
    {
        $this->postUnit = $postUnit;
        return $this;
    }

    /**
     * @return ProductImageModel
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param ProductImageModel $image
     * @return $this
     */
    public function setImage(ProductImageModel $image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return ProductCategoryModel
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param ProductCategoryModel $category
     * @return $this
     */
    public function setCategory(ProductCategoryModel $category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param $taxable
     * @return $this
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
        return $this;
    }

    /**
     * @return bool
     */
    public function getVatInc()
    {
        return $this->vatInc;
    }

    /**
     * @param $vatInc
     * @return $this
     */
    public function setVatInc($vatInc)
    {
        $this->vatInc = $vatInc;
        return $this;
    }

    /**
     * @return bool
     */
    public function getAddPostage()
    {
        return $this->addPostage;
    }

    /**
     * @param $addPostage
     * @return $this
     */
    public function setAddPostage($addPostage)
    {
        $this->addPostage = $addPostage;
        return $this;
    }

    /**
     * @return bool $showImage
     */
    public function getShowImage()
    {
        return $this->showImage;
    }
    
    /**
     * @param bool $showImage
     * @return $this
     */
    public function setShowImage($showImage)
    {
        $this->showImage = (bool) $showImage;
        return $this;
    }
    /**
     * @return ProductOptionModel
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param ProductOptionModel|null $option
     * @return $this
     */
    public function setOption(ProductOptionModel $option = null)
    {
        $this->option = $option;
        return $this;
    }
}
