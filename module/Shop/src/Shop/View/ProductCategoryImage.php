<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Shop\Model\Product\Category as CategoryModel;
use UthandoCommon\View\AbstractViewHelper;
use Zend\View\Helper\BasePath;

/**
 * Class ProductCategoryImage
 *
 * @package Shop\View
 */
class ProductCategoryImage extends AbstractViewHelper
{
    /**
     * @var string
     */
    protected $noImage = 'no_image_available.jpeg';

    /**
     * @var string
     */
    protected $image = '';

    /**
     * @var string
     */
    protected $categoryImageDirectory = '/userfiles/';

    /**
     * @var string
     */
    protected $productImageDirectory = '/userfiles/shop/images/';

    /**
     * @var string
     */
    protected $publicDir = './public_html';

    /**
     * @param CategoryModel $model
     * @return $this
     */
    public function __invoke($model)
    {
        if ($model instanceof CategoryModel) {
            $this->image = $model->getImage();
        }

        return $this;
    }

    public function getImage($withBasePath = true)
    {

        /** @var BasePath $basePath */
        $basePath = $this->getView()->plugin('basepath');
        $defaultImage = $this->image;

        if ($this->isUploaded($this->categoryImageDirectory)) {
            $directory = $this->categoryImageDirectory;
        } else {
            $directory = $this->productImageDirectory;
        }

        if (!$this->isUploaded($directory)) {
            $defaultImage = $this->noImage;
        }

        $image = $directory . $defaultImage;

        if ($withBasePath) {
            $image = $basePath($image);
        }

        return $image;
    }

    public function isUploaded($directory)
    {
        $image = ($this->image) ?: null;
        $fileExists = is_file($this->publicDir . $directory . $image);
        return $fileExists;
    }

    public function __toString()
    {
        return $this->getImage();
    }
}