<?php

namespace Shop\Form\Element;

use Shop\Model\Product\Product;
use Zend\Form\Element\Select;

class ProductOptions extends Select
{
    /**
     * @var Product
     */
    protected $product;

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
        $selectOptions = [];

        /* @var $option \Shop\Model\Product\Option */
        foreach($this->getProduct()->getProductOption() as $option) {
            $selectOptions[] = [
                'label' => $option->getOption() . ' - ' . $option->getPrice(),
                'value' => $option->getProductId() . '-' . $option->getProductOptionId(),
            ];
        }

        return $selectOptions;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
} 