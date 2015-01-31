<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Shop\Model\Product\Image as ImageModel;
use Zend\View\Helper\AbstractHelper;

/**
 * Class ProductImage
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
     * @param \Shop\Model\Product\Product|\Shop\Model\Product\Category $model
     * @return $this
     */
    public function __invoke($model)
    {
        $this->image = ($model instanceof ImageModel) ? $model : $model->getDefaultImage();
        return $this;
    }

    public function getImage($withBasePath = true)
    {
        $basePath = $this->view->plugin('basepath');
        $defaultImage = ($this->image instanceof ImageModel) ? $this->image->getThumbnail() : 'no_image_available.jpeg';
        $image = $this->imageDir . $defaultImage;

        if ($withBasePath) {
            $image = $basePath($image);
        }

        return $image;
    }
    
    public function isUploaded()
    {
        $image = $this->getImage(false);
        $fileExists = file_exists($this->publicDir.$image);
        return $fileExists;
    }

    public function __toString()
    {
        return $this->getImage();
    }
} 