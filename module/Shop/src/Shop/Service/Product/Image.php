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
    }

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getImagesByProductId($id)
    {
        $id = (int) $id;

        /* @var $mapper \Shop\Mapper\Product\Image */
        $mapper = $this->getMapper();
        $images = $mapper->getImagesByProductId($id);

        return $images;
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

        $data['isDefault'] =  ($images->count() == 0) ? '1' : '0';

        $e->setParam('data', $data);
    }
}
