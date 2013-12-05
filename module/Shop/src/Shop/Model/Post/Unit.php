<?php
namespace Shop\Model\Post;

use Application\Model\AbstractModel;

class Unit extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $postUnitId;
	
	/**
	 * @var float
	 */
	protected $postUnit;
	
	/**
	 * @return the $productPostUnitId
	 */
	public function getPostUnitId()
	{
		return $this->postUnitId;
	}

	/**
	 * @param number $productPostUnitId
	 */
	public function setProductPostUnitId($postUnitId)
	{
		$this->postUnitId = $postUnitId;
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
