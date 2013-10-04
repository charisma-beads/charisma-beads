<?php
namespace Shop\Model;

use Application\Model\AbstractModel;

class ProductStockStatus extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $productStockStautsId;
	
	/**
	 * @var string
	 */
	protected $stockStatus;
	
	/**
	 * @return the $productStockStautsId
	 */
	public function getProductStockStautsId()
	{
		return $this->productStockStautsId;
	}

	/**
	 * @param number $productStockStautsId
	 */
	public function setProductStockStautsId($productStockStautsId)
	{
		$this->productStockStautsId = $productStockStautsId;
		return $this;
	}

	/**
	 * @return the $stockStatus
	 */
	public function getStockStatus()
	{
		return $this->stockStatus;
	}

	/**
	 * @param string $stockStatus
	 */
	public function setStockStatus($stockStatus)
	{
		$this->stockStatus = $stockStatus;
		return $this;
	}
}
