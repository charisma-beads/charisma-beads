<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Where;

/**
 * Class Group
 *
 * @package Shop\Mapper
 */
class ProductGroupMapper extends AbstractDbMapper
{
    protected $table = 'productGroup';
    protected $primary = 'productGroupId';
    
    public function updateGroupProductPrices($group, $price)
    {
        $group = (int) $group;
        $price = (float) $price;
         
        $where = new Where();
        $where->equalTo('productGroupId', $group);
         
        $this->update(['price' => $price], $where, 'product');
         
    }
}
