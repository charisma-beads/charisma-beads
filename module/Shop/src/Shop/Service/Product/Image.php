<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\EventManager\Event;

/**
 * Class Image
 *
 * @package Shop\Service\Product
 * @method \Shop\Mapper\Product\Image getMapper($mapperClass = null, array $options = [])
 */
class Image extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductImage';
    
    protected $tags = [
        'image', 'product',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'product'   => [
            'refCol'    => 'productId',
            'service'   => 'ShopProduct',
        ],
    ];

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.form',
        ], [$this, 'preForm']);
        
        $this->getEventManager()->attach([
            'post.delete'
        ], [$this, 'deleteImage']);
    }

    /**
     * @param $id
     * @param bool $recursive
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getImagesByCategoryId($id, $recursive = false)
    {
        /* @var $categoryService \Shop\Service\Product\Category */
        $categoryService    = $this->getService('ShopProductCategory');
        $ids                = $categoryService->getCategoryChildrenIds($id, $recursive);
        array_push($ids, $id);
        $images             = $this->getMapper()->getImagesByCategoryIds($ids);

        return $images;
    }

    /**
     * @param $id
     * @return array
     */
    public function getImagesByProductId($id)
    {
        $id = (int) $id;

        $ProductImages = $this->getCacheItem($id.'-productImages');
        
        if (!$ProductImages) {
            /* @var $mapper \Shop\Mapper\Product\Image */
            $mapper = $this->getMapper();
            $images = $mapper->getImagesByProductId($id);
            
            $ProductImages = [];
            
            foreach ($images as $image) {
                $ProductImages[] = $image;
            }
            
            $this->setCacheItem($id.'-productImages', $ProductImages);
        }
        
        return $ProductImages;
    }
    
    public function deleteImage(Event $e)
    {
        /* @var $model \Shop\Model\Product\Image */
        $model          = $e->getParam('model');
        $imageDirectory = './public/userfiles/shop/images/';
        $files          = [];
        $files[]        = $imageDirectory . $model->getFull();
        $files[]        = $imageDirectory . $model->getThumbnail();

        foreach ($files as $file) {
            if (is_file($file) && file_exists($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Set image to default if no other images are attached to the product.
     *
     * @param Event $e
     */
    public function preForm(Event $e)
    {
        $data = $e->getParam('data');

        if (!empty($data)) {
            $productId = $data['productId'];

            $images = $this->getImagesByProductId($productId);

            if (!isset($data['isDefault'])) {
                $data['isDefault'] =  0;
            }

            if (count($images) == 0) {
                $data['isDefault'] =  1;
            }


            $e->setParam('data', $data);
        }
    }
}
