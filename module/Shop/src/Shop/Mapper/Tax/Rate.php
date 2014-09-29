<?php
namespace Shop\Mapper\Tax;

use UthandoCommon\Mapper\AbstractDbMapper;

class Rate extends AbstractDbMapper
{
	protected $table = 'taxRate';
	protected $primary = 'taxRateId';
	
}
