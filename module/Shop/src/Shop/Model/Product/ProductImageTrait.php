<?php

namespace Shop\Model\Product;


trait ProductImageTrait
{
    /**
     * @var array
     */
    protected $productImage = [];

    /**
     * @return null|Image
     */
    public function getDefaultImage()
    {
        $image = null;

        /* @var $image Image */
        foreach ($this->getProductImage() as $row) {
            if ($row->getIsDefault()) {
                $image = $row;
                break;
            }
        }

        return $image;
    }

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