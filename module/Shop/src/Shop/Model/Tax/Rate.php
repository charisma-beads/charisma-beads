<?php
namespace Shop\Model\Tax;

use Application\Model\AbstractModel;

class Rate extends AbstractModel
{
	/**
	 * @var int
	 */
	protected $taxRateId;
	
	/**
	 * @var float
	 */
	protected $taxRate;
	
	/**
	 * @return the $taxRateId
	 */
	public function getTaxRateId()
	{
		return $this->taxRateId;
	}

	/**
	 * @param number $taxRateId
	 */
	public function setTaxRateId($taxRateId)
	{
		$this->taxRateId = $taxRateId;
		return $this;
	}

	/**
	 * @return the $taxRate
	 */
	public function getTaxRate()
	{
		return $this->taxRate;
	}

	/**
	 * @param number $taxRate
	 */
	public function setTaxRate($taxRate)
	{
		$this->taxRate = $taxRate;
		return $this;
	}
}
