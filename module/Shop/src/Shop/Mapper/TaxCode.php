<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class TaxCode extends AbstractMapper
{
	protected $table = 'taxCode';
	protected $primary = 'taxCodeId';
	protected $model = 'Shop\Model\TaxCode';
	protected $hydrator = 'Shop\Hydrator\TaxCode';
}
