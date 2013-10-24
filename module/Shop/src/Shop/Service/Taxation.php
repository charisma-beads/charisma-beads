<?php
namespace Shop\Service;

class Taxation
{
    /**
     * @var int
     */
    public $taxCodeId;
    
    /**
     * @var int
     */
    public $taxInc;
    
    /**
     * @var bool
     */
    public $taxState = false;
    
    public function addTax($price, $taxRate=0)
    {   
        if ($this->taxState && $taxRate != 0) {
            if (!$this->taxInc) {
                $pat = round(($price*$taxRate), 2);
                $tax = $pat - $price;
            } else {
                $pbt = round(($price/$taxRate), 2);
                $tax = $price - $pbt;
                $price = $pbt;
            }
        } else {
            $tax = 0;
        }
        
        return array(
            'tax' => number_format($tax, 2),
            'price' => number_format($price, 2)
        );
    }
    
	/**
     * @return number $taxCodeId
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

}
