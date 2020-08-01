<?php

namespace Shop\Form\Element;

use Shop\Service\ProductImageService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class ProductCategoryImageList
 *
 * @package Shop\Form\Element
 * @method \Laminas\Form\FormElementManager getServiceLocator()
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
            /* @var $sm \Common\Service\ServiceManager */
            $sm = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ServiceManager::class);

            /* @var $imageService \Shop\Service\ProductImageService */
            $imageService = $sm->get(ProductImageService::class);


            $images = $imageService->getImagesByCategoryId($id, true);

            if ($images->count() > 0) {

                /* @var $image \Shop\Model\ProductImageModel */
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