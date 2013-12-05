<?php
namespace Shop\Mapper\Stock;

use Application\Mapper\AbstractMapper;

class Status extends AbstractMapper
{
	protected $table = 'stockStatus';
	protected $primary = 'stockStatusId';
	protected $model = 'Shop\Model\Stock\Status';
	protected $hydrator = 'Shop\Hydrator\Stock\Status';
}
