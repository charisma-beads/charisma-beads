<?php
namespace Shop\Model\DbTable;

use Application\Model\DbTable\AbstractTable;
use Zend\Db\Sql\Select;

class Product extends AbstractTable
{
	protected $table = 'product';
	protected $primary = 'productId';
	protected $rowClass = 'Shop\Model\Entity\Product';
	
	public function getProductByIdent($ident)
	{
		$ident = (string) $ident;
		$rowset = $this->tableGateway->select(array('ident', $ident));
		$row = $rowset->current();
		return $row;
	}
	
	public function getProductsByCategory(array $categoryId, $page=null, $count=null, $order=null)
	{	
		$select = $this->sql->select();
		$select->from($this->table)
			->join(
				'taxCode',
				'product.taxCodeId = taxCode.taxCodeId',
				array(),
				Select::JOIN_LEFT
			)
			->join(
				'taxRate',
				'taxCode.taxRateId = taxRate.taxRateId',
				array('taxRate'),
				Select::JOIN_LEFT
			)
			->join(
				'productPostUnit',
				'product.productPostUnitId = productPostUnit.productPostUnitId',
				array('postUnit'),
				Select::JOIN_INNER
			)
			->join(
				'productSize',
				'product.productSizeId = productSize.productSizeId',
				array('size'),
				Select::JOIN_INNER
			)->where
			->in('productCategoryId', $categoryId)
			->and->equalTo('enabled', 1)
			->and->equalTo('discontinued', 0);
	
		if (true === is_array($order)) {
			$select = $this->setSortOrder($select, $order);
		}
	
		if (null !== $page) {
			return $this->paginate($select, $page, $count);
		}
	
		return $this->fetchAll($select);
	}
}
