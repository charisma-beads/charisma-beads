<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class Code
 *
 * @package Shop\Model
 */
class TaxCodeModel implements ModelInterface
{
    use Model;
    
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
	 * @var TaxRateModel
	 */
	protected $taxRate;

    /**
     * @return int
     */
	public function getTaxCodeId()
	{
		return $this->taxCodeId;
	}

    /**
     * @param number $taxCodeId
     * @return TaxCodeModel
     */
	public function setTaxCodeId($taxCodeId)
	{
		$this->taxCodeId = $taxCodeId;
		return $this;
	}

    /**
     * @return int $taxRateId
     */
	public function getTaxRateId()
	{
		return $this->taxRateId;
	}

    /**
     * @param number $taxRateId
     * @return TaxCodeModel
     */
	public function setTaxRateId($taxRateId)
	 {
		$this->taxRateId = $taxRateId;
		return $this;
	}

    /**
     * @return string
     */
	public function getTaxCode()
	{
		return $this->taxCode;
	}

    /**
     * @param string $taxCode
     * @return TaxCodeModel
     */
	public function setTaxCode($taxCode)
	{
		$this->taxCode = $taxCode;
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
     * @param string $description
     * @return TaxCodeModel
     */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	
	/**
	 * @return TaxRateModel
	 */
	public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param TaxRateModel $taxRate
     * @return TaxCodeModel
     */
	public function setTaxRate(TaxRateModel $taxRate)
    {
        $this->taxRate = $taxRate;
        return $this;
    }

}
