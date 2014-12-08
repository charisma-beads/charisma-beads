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

use Shop\Model\Product\Category as CategoryModel;
use Shop\Model\Product\Image as ImageModel;
use Shop\Model\Product\Product as ProductModel;
use Zend\View\Helper\AbstractHelper;

/**
 * Class ProductImage
 * @package Shop\View
 */
class ProductImage extends AbstractHelper
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @param ProductModel|CategoryModel $model
     * @return $this
     */
    public function __invoke($model)
    {
        $this->image = ($model instanceof ImageModel) ? $model : $model->getDefaultImage();
        return $this;
    }

    public function getImage()
    {
        $basePath = $this->view->plugin('basepath');
        $defaultImage = ($this->image instanceof ImageModel) ? $this->image->getThumbnail() : 'no_image_available.jpeg';

        $image = $basePath('/userfiles/shop/images/' . $defaultImage);

        return $image;
    }

    public function __toString()
    {
        return $this->getImage();
    }
} 