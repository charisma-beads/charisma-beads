<?php
namespace Shop\Model\DbTable;

use Application\Model\DbTable\AbstractTable;
use FB;

class Product extends AbstractTable
{
	protected $table = 'product';
	protected $primary = 'productId';
	protected $rowClass = 'Shop\Model\Entity\Product';
	
	public function getProductByIdent($ident)
	{
		$rowset = $this->tableGateway->select(array('ident', $ident));
		$row = $rowset->current();
		return $row;
	}
	
	public function getProductsByCategory(array $categoryId, $page=null, $count=null, $order=null)
	{	
		$select = $this->sql->select();
		$select->from($this->table)->where
			->in('productCategoryId', $categoryId)
			->and->equalTo('enabled', 1)
			->and->equalTo('discontinued', 0);
	
		if (true === is_array($order)) {
			$select = $this->setSortOrder($select, $order);
		}
	
		if (null !== $page) {
			$resultSet = $this->fetchResult($select);
			return $this->paginate($resultSet, $page, $count);
		}
	
		return $this->fetchAll($select);
	}
}
