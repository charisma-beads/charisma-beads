<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\EventManager\Event;

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
        $model = $e->getParam('model');
        $file = './public/userfiles/shop/images/' . $model->getFull();
        $thumb = './public/userfiles/shop/images/' . $model->getThumbnail();
        
        if (is_file($file) && file_exists($file)) {
            unlink($file);
        }
        
        // TODO: generate thumbnail to delete.
        //unlink($thumb);
    }

    /**
     * Set image to default if no other images are attached to the product.
     *
     * @param Event $e
     */
    public function preForm(Event $e)
    {
        $data = $e->getParam('data');

        $productId = $data['productId'];

        $images = $this->getImagesByProductId($productId);

        if (count($images) == 0) {
            $data['isDefault'] =  1;
        }
        

        $e->setParam('data', $data);
    }
}
