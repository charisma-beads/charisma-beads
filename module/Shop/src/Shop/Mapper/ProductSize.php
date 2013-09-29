<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class ProductSize extends AbstractMapper
{
	protected $table = 'productSize';
	protected $primary = 'productSizeId';
	protected $model = 'Shop\Model\ProductSize';
}
