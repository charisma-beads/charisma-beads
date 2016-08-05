<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\View;

use Shop\Model\Product\Image as ImageModel;
use Zend\View\Helper\AbstractHelper;

/**
 * Class ProductImage
 *
 * @package Shop\View
 */
class ProductImage extends AbstractHelper
{
    /**
     * @var ImageModel
     */
    protected $image;
    
    /**
     * @var string
     */
    protected $imageDir = '/userfiles/shop/images/';
    
    /**
     * @var string
     */
    protected $publicDir = './public';

    /**
     * @var string
     */
    protected $noImage = '/userfiles/shop/no_image_available.jpeg';

    /**
     * @param $model
     * @param null $type
     * @return $this|string
     */
    public function __invoke($model, $type = null)
    {
        $this->image = ($model instanceof ImageModel) ? $model : $model->getDefaultImage();

        if (is_string($type)) {
            switch ($type) {
                case 'full':
                    return $this->getFull();
                case 'thumb':
                    return $this->getThumbnail();
            }
        }

        return $this;
    }

    public function getFull($withBasePath = true)
    {
        $image = $this->noImage;

        if ($this->image instanceof ImageModel) {
            $strToLower = strtolower($this->image->getFull());

            if ($this->fileExists($strToLower)) {
                $image = $this->imageDir . $strToLower;
            }

            if ($this->fileExists($this->image->getFull())) {
                $image = $this->imageDir . $this->image->getFull();
            }
        }

        if ($withBasePath) {
            $image = $this->getBasePath($image);
        }

        return $image;
    }

    public function getThumbnail($withBasePath = true)
    {
        $image = $this->noImage;

        if ($this->image instanceof ImageModel) {
            $strToLower = strtolower($this->image->getThumbnail());

            if ($this->fileExists($strToLower)) {
                $image = $this->imageDir . $strToLower;
            }

            if ($this->fileExists($this->image->getThumbnail())) {
                $image = $this->imageDir . $this->image->getThumbnail();
            }
        }

        if ($withBasePath) {
            $image = $this->getBasePath($image);
        }

        return $image;
    }

    public function fileExists($file)
    {
        $file = $this->publicDir.$this->imageDir.$file;
        $fileExists = (file_exists($file) && is_file($file)) ? true : false;
        return $fileExists;

    }
    
    public function isUploaded()
    {
        $image = ($this->image instanceof ImageModel) ? $this->getFull(false) : null;
        $fileExists = is_file($this->publicDir.$image);
        return $fileExists;
    }

    public function getBasePath($image = null)
    {
        $basePath = $this->view->plugin('basepath');
        return $basePath($image);
    }
} 