<?php
namespace Shop\Service;

class Tax
{   
    /**
     * @var int
     */
    protected $taxInc;
    
    /**
     * @var bool
     */
    protected $taxState = false;
    
    /**
     * @var decimal
     */
    protected $taxTotal;
    
    public function addTax($price, $taxRate=0)
    {   
        if ($this->taxState && $taxRate != 0) {
        	$taxRate = $taxRate + 1;
        	
            if (!$this->taxInc) {
                $pat = round(($price*($taxRate)), 2);
                $tax = $pat - $price;
            } else {
                $pbt = round(($price/($taxRate)), 2);
                $tax = $price - $pbt;
                $price = $pbt;
            }
        } else {
            $tax = 0;
        }
        
        return array(
            'tax'   => number_format($tax, 2),
            'price' => number_format($price, 2),
        );
    }

	/**
     * @return number $taxInc
     */
    public function getTaxInc()
    {
        return $this->taxInc;
    }

	/**
     * @param number $taxInc
     */
    public function setTaxInc($taxInc)
    {
        $this->taxInc = $taxInc;
        return $this;
    }

	/**
     * @return boolean $taxState
     */
    public function getTaxState()
    {
        return $this->taxState;
    }

	/**
     * @param boolean $taxState
     */
    public function setTaxState($taxState)
    {
        $this->taxState = $taxState;
        return $this;
    }
    
	/**
	 * @return \float $taxTotal
	 */
	public function getTaxTotal()
	{
		return $this->taxTotal;
	}

	/**
	 * @param float $taxTotal
	 */
	public function setTaxTotal($taxTotal)
	{
		$this->taxTotal = $taxTotal;
		return $this;
	}

}
