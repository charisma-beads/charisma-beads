<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Option
 *
 * @package Shop\Mapper
 */
class ProductOptionMapper extends AbstractDbMapper
{
	protected $table = 'productOption';
	protected $primary = 'productOptionId';

    /**
     * @param $id
     * @return \Laminas\Db\ResultSet\HydratingResultSet
     */
    public function getOptionsByProductId($id)
    {
        $id = (int) $id;

        $select = $this->getSelect();
        $select->where->equalTo('productId', $id);
        return $this->fetchResult($select);
    }
}
