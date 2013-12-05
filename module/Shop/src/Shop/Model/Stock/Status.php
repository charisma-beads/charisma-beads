<?php
namespace Shop\Model\Stock;

use Application\Model\AbstractModel;

class Status extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $stockStautsId;
	
	/**
	 * @var string
	 */
	protected $stockStatus;
	
	/**
	 * @return the $productStockStautsId
	 */
	public function getStockStautsId()
	{
		return $this->stockStautsId;
	}

	/**
	 * @param number $stockStautsId
	 */
	public function setStockStautsId($stockStautsId)
	{
		$this->stockStautsId = $stockStautsId;
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
