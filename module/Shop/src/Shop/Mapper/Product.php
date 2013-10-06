<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class Product extends AbstractMapper
{
	protected $table = 'product';
	protected $primary = 'productId';
	protected $model = 'Shop\Model\Product';
	protected $hydrator = 'Shop\Hydrator\Product';
	
	public function getProductByIdent($ident)
	{
		$ident = (string) $ident;
		$select = $this->getSelect()->where(array('ident', $ident));
		$resultSet = $this->fetchResult($select);
		$row = $resultSet->current();
		return $row;
	}
	
	public function getProductsByCategory(array $categoryId, $page=null, $count=null, $order=null)
	{
		$select = $this->getSql()->select();
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
			return $this->paginate($select, $page, $count, new ResultSet());
		}
	
		return $this->fetchAll($select, new ResultSet());
	}
}
