<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

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
