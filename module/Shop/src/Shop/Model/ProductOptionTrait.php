<?php

namespace Shop\Model;

/**
 * Class ProductOptionTrait
 *
 * @package Shop\Model
 */
trait ProductOptionTrait
{
    /**
     * @var array
     */
    protected $productOption = [];

    /**
     * @param ProductOptionModel|array $productOptionOrOptions
     */
    public function setProductOption($productOptionOrOptions)
    {   
        if ($productOptionOrOptions instanceof ProductOptionModel) {
            $productOptionOrOptions = [$productOptionOrOptions];
        }
        
        foreach ($productOptionOrOptions as $option) {
            $this->productOption[] = $option;
        }
    }

    /**
     * @param int|null $id
     * @return array|null|ProductOptionModel
     */
    public function getProductOption($id = null)
    {
        $productOptionOrOptions = null;

        if (is_int($id)) {
            /* @var $option ProductOptionModel */
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