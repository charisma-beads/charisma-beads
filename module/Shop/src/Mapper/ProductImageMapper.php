<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Select;

/**
 * Class Image
 *
 * @package Shop\Mapper
 */
class ProductImageMapper extends AbstractDbMapper
{
	protected $table = 'productImage';
	protected $primary = 'productImageId';

    /**
     * @param $id
     * @return \Laminas\Db\ResultSet\HydratingResultSet
     */
    public function getImagesByProductId($id)
    {
        $id = (int) $id;

        $select = $this->getSelect();
        $select->where->equalTo('productId', $id);
        return $this->fetchResult($select);
    }

    /**
     * @param array $ids
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
	public function getImagesByCategoryIds(array $ids)
	{
		$select = $this->getSql()->select();
		$select->from($this->table)
		->join(
			'product',
			'productImage.productId=product.productId',
			array(),
			Select::JOIN_INNER
		);
		
		$select->where->in('productCategoryId', $ids);
		
		return $this->fetchResult($select);
	}

    /**
     * @param array $search
     * @param string $sort
     * @param null $select
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
	public function search(array $search, $sort, $select = null)
	{
	    $select = $this->getSql()->select();
	    $select->from($this->table)
        ->join(
            'product',
            'productImage.productId=product.productId',
            array(),
            Select::JOIN_INNER     
	    );
	    
	    return parent::search($search, $sort, $select);
	}
}
