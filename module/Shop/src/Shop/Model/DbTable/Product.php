<?php
namespace Shop\Model\DbTable;

use Application\Model\DbTable\AbstractTable;
use FB;

class Product extends AbstractTable
{
	protected $table = 'product';
	protected $primary = 'prodctId';
	protected $rowClass = 'Shop\Model\Entity\Product';
	
	public function getProductByIdent($ident)
	{
		$rowset = $this->tableGateway->select(array('ident', $ident));
		$row = $rowset->current();
		return $row;
	}
	
	public function getProductsByCategory($categoryId, $page=null, $count=null, $order=null)
	{
		$categoryId = implode(',', $categoryId);
		
		$select = $this->sql->select();
		$select->from($this->table)->where(array(
			'productCategoryId IN(?)'	=> $categoryId,
			'enabled'			=> 1,
			'discontinued'		=> 0
		));
	
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
