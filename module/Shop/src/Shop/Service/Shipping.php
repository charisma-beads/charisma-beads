<?php
namespace Shop\Service;

use Shop\Service\Cart;

class Shipping
{
    protected $countryService;
    
    protected $taxService;
    
    protected $countryId;
    
    protected $postWeight = 0;
    
    protected $noShipping = 0;
    
    protected $shippingTax = 0;
    
    protected $shippingTotal = 0;
    
    protected $shippingByWeight = false;
    
    public function calculateShipping(Cart $cart)
    {
        $this->noShipping = 0;
        $this->postWeight = 0;
        $this->shippingTax = 0;
        
        $taxService = $this->getTaxService();
        
        foreach ($cart as $item) {
            if ($item->getAddPostage() === true) {
            	$this->postWeight += $item->getPostunit() * $item->getQty();
            } else {
            	$this->noShipping += $cart->getLineCost($item);
            }
        }
        
        if ($this->getShippingByWeight() === true) {
            $itemLevel = $this->getPostWeight();
        } else {
            $itemLevel = $cart->getSubTotal() - $this->getNoShipping();
        }
        
        if ($itemLevel == $this->getNoShipping()) {
            return;
        }
        
        $shippingLevels = $this->getCountryService()->getCountryPostalRates($this->getCountryId());
        
        $postVatInc = 0;
        $postTaxRate = 0;
        
        foreach ($shippingLevels as $row) {
        	if ($itemLevel > $row->postLevel) {
        	   $this->shippingTotal = $row->cost;
        	   $taxInc = $row->vatInc;
        	   $taxRate = $row->taxRate;
        	}
        }
        
        $taxService = $this->getTaxService()->setTaxInc($taxInc);
        
        $price = $taxService->addTax($this->shippingTotal, $taxRate);
        
        $this->setShippingTax($price['tax']);
        
        \FB::info($this->shippingTotal);
        \FB::info($itemLevel);
        \FB::info($price);
        
        return $price['price'] + $price['tax'];
    }
    
    /**
	 * @return field_type $countryCode
	 */
	public function getCountryId()
	{
		return $this->countryId;
	}

	/**
	 * @param field_type $countryId
	 */
	public function setCountryId($countryId)
	{
		$this->countryId = $countryId;
		return $this;
	}

	/**
	 * @return field_type $postWeight
	 */
	public function getPostWeight()
	{
		return $this->postWeight;
	}

	/**
	 * @param field_type $postWeight
	 */
	public function setPostWeight($postWeight)
	{
		$this->postWeight = $postWeight;
		return $this;
	}

	/**
	 * @return number $noShipping
	 */
	public function getNoShipping()
	{
		return $this->noShipping;
	}

	/**
	 * @param number $noShipping
	 */
	public function setNoShipping($noShipping)
	{
		$this->noShipping = $noShipping;
		return $this;
	}

	/**
	 * @return number $shippingTax
	 */
	public function getShippingTax()
	{
		return $this->shippingTax;
	}

	/**
	 * @param number $shippingTax
	 */
	public function setShippingTax($shippingTax)
	{
		$this->shippingTax = $shippingTax;
		return $this;
	}

	/**
	 * @return boolean $shippingByWeight
	 */
	public function getShippingByWeight()
	{
		return $this->shippingByWeight;
	}

	/**
	 * @param boolean $shippingByWeight
	 */
	public function setShippingByWeight($shippingByWeight)
	{
		$this->shippingByWeight = $shippingByWeight;
		return $this;
	}

	/**
     * @return \Shop\Service\Country $countryService
     */
    public function getCountryService()
    {
    	return $this->countryService;
    }
    
    /**
     * @param \Shop\Service\Country $countryervice
     */
    public function setCountryService($countryService)
    {
    	$this->countryService = $countryService;
    	return $this;
    }
    
    /**
     * @return \Shop\Service\Tax $taxService
     */
    public function getTaxService()
    {
    	return $this->taxService;
    }
    
    /**
     * @param \Shop\Service\Tax $taxService
     */
    public function setTaxService($taxService)
    {
    	$this->taxService = $taxService;
    	return $this;
    }
}
