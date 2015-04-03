<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoShop
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Model\Product;

/**
 * Class ProductImageTrait
 * @package Shop\Model\Product
 */
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
        
        if (null === $image) {
            $image = new Image();
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
            if (!$images->getProductImageId()) {
                return $this;
            }
            $images = [$images];
        }

        $this->productImage = $images;

        return $this;
    }
} 