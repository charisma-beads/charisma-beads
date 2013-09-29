<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class ProductPostUnit extends AbstractMapper
{
	protected $table = 'productPostUnit';
	protected $primary = 'productPostUnitId';
	protected $model = 'Shop\Model\ProductPostUnit';
}
