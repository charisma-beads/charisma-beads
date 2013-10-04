<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractNestedSet;

class ProductCategory extends AbstractNestedSet
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
	protected $model = 'Shop\Model\ProductCategory';
	protected $hydrator = 'Shop\Hydrator\ProductCategory';
	
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;
		$select = $this->getSelect()->where(array('ident' => $ident));
		$resultSet = $this->fetchResult($select);
		$row = $resultSet->current();
		return $row;
	}
}
