<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Rate
 *
 * @package Shop\Mapper
 */
class TaxRateMapper extends AbstractDbMapper
{
	protected $table = 'taxRate';
	protected $primary = 'taxRateId';
	
}
