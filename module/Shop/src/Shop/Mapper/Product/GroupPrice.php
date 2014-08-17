<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractMapper;

class GroupPrice extends AbstractMapper
{
    protected $table = 'productGroupPrice';
    protected $primary = 'productGroupId';
    protected $model = 'Shop\Model\Product\GroupPrice';
    protected $hydrator = 'Shop\Hydrator\Product\GroupPrice';
}
