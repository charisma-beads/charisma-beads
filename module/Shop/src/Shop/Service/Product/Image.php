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
     * @param array $post
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $post)
    {	 
    	$models = parent::search($post);

        /* @var $model \Shop\Model\Product\Image */
    	foreach ($models as $model) {
    	    $this->populate($model, true);
    	}
    	
    	return $models;
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
        $options = $mapper->getImagesByProductId($id);

        return $options;
    }
}
