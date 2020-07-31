<?php

namespace Shop\Model;

/**
 * Class ProductImageTrait
 *
 * @package Shop\Model
 */
trait ProductImageTrait
{
    /**
     * @var array
     */
    protected $productImage = [];

    /**
     * @return null|ProductImageModel
     */
    public function getDefaultImage()
    {
        $image = null;

        /* @var $row ProductImageModel */
        foreach ($this->getProductImage() as $row) {
            if ($row->getIsDefault()) {
                $image = $row;
                break;
            }
        }
        
        if (null === $image) {
            $image = new ProductImageModel();
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
        if ($images instanceof ProductImageModel) {
            if (!$images->getProductImageId()) {
                return $this;
            }
            $images = [$images];
        }

        $this->productImage = $images;

        return $this;
    }
} 