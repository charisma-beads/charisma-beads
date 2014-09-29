<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

class Image extends AbstractDbMapper
{
	protected $table = 'productImage';
	protected $primary = 'productImageId';
	
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
	
	public function search(array $search, $sort, Select $select = null)
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
