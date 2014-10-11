<?php

namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

class Option extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductOption';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getOptionsByProductId($id)
    {
        $id = (int) $id;

        /* @var $mapper \Shop\Mapper\Product\Option */
        $mapper = $this->getMapper();
        $options = $mapper->getOptionsByProductId($id);

        return $options;
    }
} 