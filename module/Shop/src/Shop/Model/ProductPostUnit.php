<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class ProductPostUnit extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $productPostUnitId;
	
	/**
	 * @var float
	 */
	protected $postUnit;
	
	/**
	 * @return the $productPostUnitId
	 */
	public function getProductPostUnitId()
	{
		return $this->productPostUnitId;
	}

	/**
	 * @param number $productPostUnitId
	 */
	public function setProductPostUnitId($productPostUnitId)
	{
		$this->productPostUnitId = $productPostUnitId;
		return $this;
	}

	/**
	 * @return the $postUnit
	 */
	public function getPostUnit()
	{
		return $this->postUnit;
	}

	/**
	 * @param number $postUnit
	 */
	public function setPostUnit($postUnit)
	{
		$this->postUnit = $postUnit;
		return $this;
	}
}
