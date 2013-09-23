<?php
namespace Shop\Model\DbTable\Product;

use Application\Model\DbTable\AbstractNestedSet;

class Category extends AbstractNestedSet
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
	protected $rowClass = 'Shop\Model\Entity\Product\Category';
	
	public function getCategoryByIdent($ident)
	{
		$ident = (string) $ident;
		$rowset = $this->tableGateway->select(array('ident' => $ident));
		$row = $rowset->current();
		return $row;
	}
}
