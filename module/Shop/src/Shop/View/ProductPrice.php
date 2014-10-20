<?php
namespace Shop\View;

use Shop\Model\Product\Product;
use UthandoCommon\View\AbstractViewHelper;

class ProductPrice extends AbstractViewHelper
{
    /**
     * @var string
     */
    protected $format = '<p><b>%s</b> for %s gms</p>%s';

    protected $productOptions = '<p>%s</p>';
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
    public function render()
    {
        $product = $this->product;

        $currency = $this->getPriceFormatHelper();
        $formatted = '';
        $options = null;

        if ($product->getProductOption()) {
            $formatted .= 'From ';
            $options = sprintf($this->productOptions, $this->getProductOptions());
        }

        $formatted .= $currency($product->getPrice());

        if ($product->isDiscounted()) {
            $formatted .= ' was <del>' . $currency($product->getPrice(false)) . '</del>';
        }

        return sprintf($this->format, $formatted, $product->getPostUnit()->getPostUnit(), $options);
    }

    /**
     * @return \Shop\Form\Element\ProductOptions
     */
    public function getProductOptions()
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $formManager = $sl->get('FormElementManager');

        $options = $formManager->get('ProductOptionList', [
            'product' => $this->product,
        ]);

        $select = $this->view->plugin('formSelect');

        return $select($options);
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
