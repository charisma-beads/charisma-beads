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
 * Class Group
 *
 * @package Shop\Model
 */
class ProductGroupModel implements ModelInterface
{
    use Model;
    
    /**
     * @var int
     */
    protected $productGroupId;
    
    /**
     * @var string
     */
    protected $group;
    
    /**
     * @var float
     */
    protected $price;
    
	/**
	 * @return number $groupId
	 */
	public function getProductGroupId()
	{
		return $this->productGroupId;
	}

    /**
     * @param $productGroupId
     * @return $this
     */
    public function setProductGroupId($productGroupId)
	{
		$this->productGroupId = $productGroupId;
		return $this;
	}

	/**
	 * @return string $group
	 */
	public function getGroup()
	{
		return $this->group;
	}

    /**
     * @param $group
     * @return $this
     */
    public function setGroup($group)
	{
		$this->group = $group;
		return $this;
	}

	/**
	 * @return number $price
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
		$this->price = (float) $price;
		return $this;
	}
}
