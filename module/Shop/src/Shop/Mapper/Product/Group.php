<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Where;

class Group extends AbstractDbMapper
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
