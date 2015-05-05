<?php

namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Option extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductOption';
    
    protected $tags = [
        'product', 'post-unit', 'option',
    ];

    protected $referenceMap = [
        'product'   => [
            'refCol'    => 'productId',
            'service'   => 'ShopProduct',
        ],
        'postUnit'          => [
            'refCol'    => 'postUnitId',
            'service'   => 'ShopPostUnit',
        ],
    ];

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getOptionsByProductId($id)
    {
        $id = (int) $id;
        
        $ProductOptions = $this->getCacheItem($id.'-productOptions');

        if (null === $ProductOptions) {
            /* @var $mapper \Shop\Mapper\Product\Option */
            $mapper = $this->getMapper();
            $options = $mapper->getOptionsByProductId($id);
            
            $ProductOptions = [];
            
            foreach ($options as $row) {
                $ProductOptions[] = $this->populate($row, ['postUnit']);
            }
            
            $this->setCacheItem($id.'-productOptions', $ProductOptions);
        }

        return $ProductOptions;
    }
} 