<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class ProductStockStatus extends AbstractMapper
{
	protected $table = 'productStockStatus';
	protected $primary = 'productStockStatusId';
	protected $model = 'Shop\Model\ProductStockStatus';
}
