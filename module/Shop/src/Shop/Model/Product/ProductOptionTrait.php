<?php

namespace Shop\Model\Product;


trait ProductOptionTrait
{
    /**
     * @var array
     */
    protected $productOption = [];

    /**
     * @param Option $productOption
     */
    public function setProductOption($productOption)
    {
        if ($productOption instanceof Option) {
            $productOption[] = [$productOption];
        }

        $this->productOption = $productOption;
    }

    /**
     * @param int|null $id
     * @return array|null|Option
     */
    public function getProductOption($id = null)
    {
        $productOptionOrOptions = null;

        if (is_int($id)) {
            /* @var $option Option */
            foreach ($this->productOption as $option) {
                if ($id === $option->getProductOptionId()) {
                    $productOptionOrOptions = $option;
                    break;
                }
            }
        } else {
            $productOptionOrOptions = $this->productOption;
        }

        return $productOptionOrOptions;
    }
} 