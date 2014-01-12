<?php
namespace Shop\Mapper\Product;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Image extends AbstractMapper
{
	protected $table = 'productImage';
	protected $primary = 'productImageId';
	protected $model = 'Shop\Model\Product\Image';
	protected $hydrator = 'Shop\Hydrator\Product\Image';
	
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
	
	public function searchImages($image, $product, $sort)
	{
	    $select = $this->getSql()->select();
	    $select->from($this->table)
        ->join(
            'product',
            'productImage.productId=product.productId',
            array(),
            Select::JOIN_INNER     
	    );
	     
	    if (!$image == '') {
	    	if (substr($image, 0, 1) == '=') {
	    		$id = (int) substr($image, 1);
	    		$select->where->equalTo($this->primary, $id);
	    	} else {
	    		$searchTerms = explode(' ', $image);
	    		$where = $select->where->nest();
	    
	    		foreach ($searchTerms as $value) {
	    			$where->like('full', '%'.$value.'%')
	    			->or
	    			->like('thumbnail',  '%'.$value.'%');
	    		}
	    
	    		$where->unnest();
	    	}
	    }
	     
	    if (!$product == '') {
	    	$select->where
	    	->nest()
	    	->like('name', '%'.$product.'%')
	    	->unnest();
	    }
	     
	    $select = $this->setSortOrder($select, $sort);
	    
	    return $this->fetchResult($select);
	}
}
