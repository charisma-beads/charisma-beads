<?php
namespace Shop\Mapper\Tax;

use UthandoCommon\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Code extends AbstractMapper
{
	protected $table = 'taxCode';
	protected $primary = 'taxCodeId';
	protected $model = 'Shop\Model\Tax\Code';
	protected $hydrator = 'Shop\Hydrator\Tax\Code';
	
	public function search(array $search, $sort, Select $select = null)
	{
		$select = $this->getSql()->select();
		$select->from($this->getTable())
		->join(
			'taxRate',
			'taxCode.taxRateId=taxRate.taxRateId',
			array(),
			Select::JOIN_INNER
		);
		
		return parent::search($search, $sort, $select);
	}
}
