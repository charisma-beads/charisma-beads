<?php
namespace Shop\Model\Tax;

use Application\Model\Model;
use Application\Model\ModelInterface;
use Application\Model\RelationalModel;

class Rate implements ModelInterface
{
    use Model, RelationalModel;
    
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
	public function getTaxRate($formatPercent=false)
	{
		return (true === $formatPercent) ? $this->taxRate / 100 : $this->taxRate;
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
