<?php
namespace Shop\Mapper\Tax;

use Application\Mapper\AbstractMapper;

class Code extends AbstractMapper
{
	protected $table = 'taxCode';
	protected $primary = 'taxCodeId';
	protected $model = 'Shop\Model\Tax\Code';
	protected $hydrator = 'Shop\Hydrator\Tax\Code';
}
