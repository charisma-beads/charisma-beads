<?php
namespace Shop\View;

use Application\View\AbstractViewHelper;
use Shop\Model\Product as ProductModel;
use Zend\I18n\View\Helper\CurrencyFormat;

class Product extends AbstractViewHelper
{
    protected $currencyHelper;
    
    public function getEnabled(ProductModel $product)
    {
        $url = $this->view->url('admin/shop/product/edit', array(
			'action'   => 'change-product-status',
            'id'       => $product->getProductId()
		));
        
        $format = '<p class="product-status"><a href="%s" class="glyphicons %s product-%s">&nbsp;</a></p>';
        
        if ($product->getEnabled()) {
            $icon = 'ok';
            $class = 'enabled';
        } else {
            $icon = 'remove';
            $class = 'disabled';
        }
        
        return sprintf($format, $url, $icon, $class);
    }
    
    public function formatAmount($amount)
    {
    	$currency = $this->getCurrencyHelper();
    	return $currency($amount);
    }
    
    /**
     * @return CurrencyFormat
     */
    protected function getCurrencyHelper()
    {
    	if (!$this->currencyHelper instanceof CurrencyFormat) {
    		$this->currencyHelper = $this->view->plugin('currencyFormat')
    		->setCurrencyCode("GBP")->setLocale("en_GB");
    	}
    
    	return $this->currencyHelper;
    }
}
