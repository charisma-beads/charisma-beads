<?php

namespace Shop\Model\Product;


trait ProductImageTrait
{
    /**
     * @var array
     */
    protected $productImage = [];

    /**
     * @return array
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * @param $images
     * @return $this
     */
    public function setProductImage($images)
    {
        if ($images instanceof Image) {
            $images = [$images];
        }

        $this->productImage = $images;

        return $this;
    }
} 