<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ProductCategoryImageList
 *
 * @package Shop\Form\Element
 * @method \Zend\Form\FormElementManager getServiceLocator()
 */
class ProductCategoryImageList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var int
     */
    protected $categoryId;

    public function init()
    {
        $this->setName('image-select');
    }

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($this->options['category_id'])) {
            $this->setCategoryId($this->options['category_id']);
        }

        return $this;
    }

    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getListOptions();
    }

    public function getListOptions()
    {
        $id = $this->getCategoryId();
        $imageOptions = [];

        if (!0 == $id) {
            /* @var $sm \UthandoCommon\Service\ServiceManager */
            $sm = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('UthandoServiceManager');

            /* @var $imageService \Shop\Service\Product\Image */
            $imageService = $sm->get('ShopProductImage');


            $images = $imageService->getImagesByCategoryId($id, true);

            if ($images->count() > 0) {

                /* @var $image \Shop\Model\Product\Image */
                foreach($images as $image) {
                    $imageOptions[$image->getThumbnail()] = $image->getThumbnail();
                }
            } else {
                $imageOptions[0] = 'No Images Uploaded';
            }
        } else {
            $imageOptions[0] = 'No Images Uploaded';
        }

        return $imageOptions;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return $this
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }
}