<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class TaxRate extends AbstractMapper
{
	protected $table = 'taxRate';
	protected $primary = 'taxRateId';
	protected $model = 'Shop\Model\TaxRate';
}
