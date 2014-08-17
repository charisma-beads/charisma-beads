<?php
namespace Shop\Mapper\Tax;

use UthandoCommon\Mapper\AbstractMapper;

class Rate extends AbstractMapper
{
	protected $table = 'taxRate';
	protected $primary = 'taxRateId';
	protected $model = 'Shop\Model\Tax\Rate';
	protected $hydrator = 'Shop\Hydrator\Tax\Rate';
	
}
