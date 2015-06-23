<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use UthandoCommon\View\AbstractViewHelper;
use Zend\I18n\View\Helper\CurrencyFormat;

/**
 * Class PriceFormat
 *
 * @package Shop\View
 */
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
