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

use Shop\Model\Product\Product as ProductModel;
use UthandoCommon\View\AbstractViewHelper;

/**
 * Class ProductPrice
 *
 * @package Shop\View
 */
class ProductPrice extends AbstractViewHelper
{
    /**
     * @var string
     */
    protected $format = '<p itemprop="offers" itemscope itemtype="https://schema.org/Offer"><b itemprop="price">%s</b>%s %s</p>';

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
    public function __invoke(ProductModel $product)
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
        
        if ($product->getPostUnit()->getPostUnit() > 0) {
            $weight = 'for ' . $product->getPostUnit()->getPostUnit() . ' grams';
        } else {
            $weight = null;
        }

        $formatted .= $currency($product->getPrice());

        if ($product->isDiscounted()) {
            $discount = sprintf($this->discountFormat, $currency($product->getPrice(false)));
        }

        return sprintf($this->format, $formatted, $discount, $weight);
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
