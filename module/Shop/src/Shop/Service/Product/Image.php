<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractRelationalMapperService;

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
            'service'   => 'Shop\Service\Product',
        ],
    ];

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
}
