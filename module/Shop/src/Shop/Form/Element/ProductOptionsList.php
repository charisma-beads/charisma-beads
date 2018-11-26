<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use Shop\Model\ProductModel;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ProductOptionsList
 *
 * @package Shop\Form\Element
 */
class ProductOptionsList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var ProductModel
     */
    protected $product;

    /**
     * @var array
     */
    protected $attributes = [
        'class' => 'form-control',
    ];

    /**
     * @param array|\Traversable $options
     * @return void|Select|\Zend\Form\ElementInterface
     */
    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($this->options['product'])) {
            $this->setProduct($this->options['product']);
        }
    }

    /**
     * @return array|void
     */
    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getProductOptions();
    }

    /**
     * @return array
     */
    public function getProductOptions()
    {
        $viewHelperManager = $this->getServiceLocator()->getServiceLocator()->get('ViewHelperManager');
        $priceFormat = $viewHelperManager->get('PriceFormat');

        $product = $this->getProduct();

        $selectOptions = [];

        /* @var $option \Shop\Model\ProductOptionModel */
        foreach($product->getProductOption() as $option) {
            $selectOptions[] = [
                'label' => $option->getOption() . ' - ' . $priceFormat($option->getPrice()),
                'value' => $option->getProductId() . '-' . $option->getProductOptionId(),
            ];
        }

        return $selectOptions;
    }

    /**
     * @return ProductModel
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param ProductModel $product
     */
    public function setProduct(ProductModel $product)
    {
        $this->product = $product;
    }
} 