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
     * @var float
     */
    protected $tax;
    
    /**
     * @var float
     */
    protected $price;
    
    public function addTax($price, $taxRate=0)
    {   
        if ($this->taxState && $taxRate != 0) {
        	$taxRate = $taxRate + 1;
        	
            if (!$this->taxInc) {
                $pat = round($price*$taxRate, 2);
                $tax = $pat - $price;
            } else {
                $pbt = round($price/$taxRate, 2);
                $tax = $price - $pbt;
                $price = $pbt;
            }
        } else {
            $tax = 0;
        }
        
        $this->setTax(number_format($tax, 2))
            ->setPrice(number_format($price, 2));
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
	 * @return number
	 */
	public function getTax()
	{
		return $this->tax;
	}

	/**
	 * @param float $taxTotal
	 */
	public function setTax($tax)
	{
		$this->tax = $tax;
		return $this;
	}
	
	/**
	 * @return number
	 */
	public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
	public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }


}
