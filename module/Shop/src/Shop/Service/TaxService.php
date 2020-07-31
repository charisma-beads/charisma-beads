<?php

namespace Shop\Service;

/**
 * Class Tax
 *
 * @package Shop\Service
 */
class TaxService
{   
    /**
     * @var bool
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

    /**
     * @param float $price
     * @param int $taxRate
     */
    public function addTax($price, $taxRate=0)
    {

        if ($taxRate > 1) $taxRate = $taxRate / 100;


        if ($this->taxState && $taxRate != 0) {

        	$taxRate = $taxRate + 1;

            if (!$this->taxInc) {
                $pat = round($price * $taxRate, 2);
                $tax = $pat - $price;

            } else {
                $pbt = round($price / $taxRate, 2);
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
     * @return bool
     */
    public function getTaxInc()
    {
        return $this->taxInc;
    }

    /**
     * @param $taxInc
     * @return $this
     */
    public function setTaxInc($taxInc)
    {
        $this->taxInc = $taxInc;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTaxState()
    {
        return $this->taxState;
    }

    /**
     * @param $taxState
     * @return $this
     */
    public function setTaxState($taxState)
    {
        $this->taxState = $taxState;
        return $this;
    }

    /**
     * @return float
     */
    public function getTax()
	{
		return $this->tax;
	}

    /**
     * @param $tax
     * @return $this
     */
    public function setTax($tax)
	{
		$this->tax = $tax;
		return $this;
	}

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}
