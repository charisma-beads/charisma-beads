<?php
namespace Shop\Model\Tax;

use Application\Model\Model;
use Application\Model\ModelInterface;
use Application\Model\RelationalModel;

class Code implements ModelInterface
{
    use Model, RelationalModel;
    
	/**
	 * @var int
	 */
	protected $taxCodeId;
	
	/**
	 * @var int
	 */
	protected $taxRateId;
	
	/**
	 * @var string
	 */
	protected $taxCode;
	
	/**
	 * @var string
	 */
	protected $description;
	
	/**
	 * @return the $taxCodeId
	 */
	public function getTaxCodeId()
	{
		return $this->taxCodeId;
	}

	/**
	 * @param number $taxCodeId
	 */
	public function setTaxCodeId($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

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
	 * @return the $taxCode
	 */
	public function getTaxCode()
	{
		return $this->taxCode;
	}

	/**
	 * @param string $taxCode
	 */
	public function setTaxCode($taxCode)
	{
		$this->taxCode = $taxCode;
		return $this;
	}

	/**
	 * @return the $description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
}
