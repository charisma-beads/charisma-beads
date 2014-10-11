<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;

class Option extends AbstractDbMapper
{
	protected $table = 'productOption';
	protected $primary = 'productOptionId';

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getOptionsByProductId($id)
    {
        $id = (int) $id;

        $select = $this->getSelect();
        $select->where->equalTo('productId', $id);
        return $this->fetchResult($select);
    }
}
