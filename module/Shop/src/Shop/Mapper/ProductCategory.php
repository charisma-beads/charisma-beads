<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractNestedSet;

class ProductCategory extends AbstractNestedSet
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
	protected $rowClass = 'Shop\Model\ProductCategory';
	
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;
		$rowset = $this->getTablegateway()->select(array('ident' => $ident));
		$row = $rowset->current();
		return $row;
	}
}
