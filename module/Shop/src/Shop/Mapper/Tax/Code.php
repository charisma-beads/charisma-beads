<?php
namespace Shop\Mapper\Tax;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

class Code extends AbstractDbMapper
{
	protected $table = 'taxCode';
	protected $primary = 'taxCodeId';
	
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
