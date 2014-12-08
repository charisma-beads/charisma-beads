<?php
namespace Shop\View;

use Shop\Model\Product\Product;
use UthandoCommon\View\AbstractViewHelper;

class ProductPrice extends AbstractViewHelper
{
    /**
     * @var string
     */
    protected $format = '<p><b>%s</b>%s for %s gms</p>';

    protected $discountFormat = ' was <del>%s</del>';

    /**
     * @var PriceFormat
     */
    protected $priceFormatHelper;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @param Product $product
     * @return $this
     */
    public function __invoke(Product $product)
    {
        $this->product = $product;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountFormat()
    {
        return $this->discountFormat;
    }

    /**
     * @param string $discountFormat
     * @return $this
     */
    public function setDiscountFormat($discountFormat)
    {
        $this->discountFormat = $discountFormat;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $product = $this->product;

        $currency = $this->getPriceFormatHelper();
        $formatted = '';
        $discount = '';

        if ($product->getProductOption()) {
            $formatted .= 'From ';
        }

        $formatted .= $currency($product->getPrice());

        if ($product->isDiscounted()) {
            $discount = sprintf($this->discountFormat, $currency($product->getPrice(false)));
        }

        return sprintf($this->format, $formatted, $discount, number_format($product->getPostUnit()->getPostUnit()));
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
