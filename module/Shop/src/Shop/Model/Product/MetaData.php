<?php
namespace Shop\Model\Product;

class MetaData
{   
    /**
     * @var int
     */
    protected $productId;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var float
     */
    protected $postUnit;
    
    /**
     * @var string
     */
    protected $image;
    
    /**
     * @var string
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
     * @var string
     */
    protected $optionName;
    
    /**
     * @var array
     */
    protected $options = [];
    
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
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $category
     * @return $this
     */
    public function setCategory($category)
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
     * @return string
     */
    public function getOptionName()
    {
        return $this->optionName;
    }

    /**
     * @param $optionName
     * @return $this
     */
    public function setOptionName($optionName)
    {
        $this->optionName = $optionName;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
