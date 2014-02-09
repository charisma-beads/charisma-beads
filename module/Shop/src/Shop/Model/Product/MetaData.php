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
	 * @param int $productId
	 * @return \Shop\Model\Product\MetaData
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
     * @param string $name
     * @return \Shop\Model\Product\MetaData
     */
	public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return number
     */
	public function getPostUnit()
    {
        return $this->postUnit;
    }

    /**
     * @param number $postUnit
     * @return \Shop\Model\Product\MetaData
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
	 * @param string $image
	 * @return \Shop\Model\Product\MetaData
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

	public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return boolean
     */
	public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param boolean $taxable
     * @return \Shop\Model\Product\MetaData
     */
	public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
        return $this;
    }

    /**
     * @return boolean
     */
	public function getVatInc()
    {
        return $this->vatInc;
    }

    /**
     * @param boolean $vatInc
     * @return \Shop\Model\Product\MetaData
     */
	public function setVatInc($vatInc)
    {
        $this->vatInc = $vatInc;
        return $this;
    }

    /**
     * @return boolean
     */
	public function getAddPostage()
    {
        return $this->addPostage;
    }

    /**
     * @param boolean $addPostage
     * @return \Shop\Model\Product\MetaData
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
	 * @param string $optionName
	 * @return \Shop\Model\Product\MetaData
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
	 * @return \Shop\Model\Product\MetaData
	 */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
