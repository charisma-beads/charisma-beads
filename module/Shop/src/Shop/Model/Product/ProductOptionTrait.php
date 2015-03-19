<?php

namespace Shop\Model\Product;


trait ProductOptionTrait
{
    /**
     * @var array
     */
    protected $productOption = [];

    /**
     * @param Option|array $productOptionOrOptions
     */
    public function setProductOption($productOptionOrOptions)
    {   
        if ($productOptionOrOptions instanceof Option) {
            $productOptionOrOptions = [$productOptionOrOptions];
        }
        
        foreach ($productOptionOrOptions as $option) {
            $this->productOption[] = $option;
        }
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
                if ($id == $option->getProductOptionId()) {
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