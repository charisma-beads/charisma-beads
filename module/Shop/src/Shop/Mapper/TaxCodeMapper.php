<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Select;

/**
 * Class Code
 *
 * @package Shop\Mapper
 */
class TaxCodeMapper extends AbstractDbMapper
{
	protected $table = 'taxCode';
	protected $primary = 'taxCodeId';
	
	public function search(array $search, $sort, $select = null)
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
