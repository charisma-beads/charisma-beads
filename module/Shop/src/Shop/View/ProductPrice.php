<?php
namespace Shop\View;

use Zend\Form\View\Helper\AbstractHelper;
use Shop\Model\Product\Product;

class ProductPrice extends AbstractHelper
{
    protected $priceFormatHelper;
    
    public function __invoke(Product $product)
    {
        $currency = $this->getPriceFormatHelper();
        $formatted = $currency($product->getPrice());
        
        if ($product->isDiscounted()) {
        	$formatted .= ' was <del>' . $currency($product->getPrice(false)) . '</del>';
        }
        
        return $formatted;
    }
    
    /**
     * @return PriceFormat
     */
    public function getPriceFormatHelper()
    {
        if (!$this->priceFormatHelper instanceof PriceFormat) {
        	$this->priceFormatHelper = $this->view->plugin('priceFormat');
        }
        
        return $this->priceFormatHelper;
    }
}
