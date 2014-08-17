<?php
namespace Shop\View;

use UthandoCommon\View\AbstractViewHelper;
use Zend\I18n\View\Helper\CurrencyFormat;

class PriceFormat extends AbstractViewHelper
{
    protected $currencyHelper;
    
    public function __invoke($amount)
    {
    	$currency = $this->getCurrencyHelper()
    		->setCurrencyCode("GBP")
    		->setLocale("en_GB");
    	
    	return $currency($amount);
    }
    
    /**
     * @return CurrencyFormat
     */
    protected function getCurrencyHelper()
    {
    	if (!$this->currencyHelper instanceof CurrencyFormat) {
    		$this->currencyHelper = $this->view->plugin('currencyFormat');
    	}
    
    	return $this->currencyHelper;
    }
}
