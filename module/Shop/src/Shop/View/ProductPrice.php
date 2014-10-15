<?php
namespace Shop\View;

use Shop\Model\Product\Product;
use Zend\View\Helper\AbstractHelper;

class ProductPrice extends AbstractHelper
{
    protected $priceFormatHelper;
    
    public function __invoke(Product $product)
    {
        $currency = $this->getPriceFormatHelper();
        $formatted = '';

        if ($product->getProductOption()) {
            $formatted .= 'From ';
        }

        $formatted .= $currency($product->getPrice());
        
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
