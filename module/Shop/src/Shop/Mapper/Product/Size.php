<?php
namespace Shop\Mapper\Product;

use Application\Mapper\AbstractMapper;

class Size extends AbstractMapper
{
	protected $table = 'productSize';
	protected $primary = 'productSizeId';
	protected $model = 'Shop\Model\Product\Size';
	protected $hydrator = 'Shop\Hydrator\Product\Size';
}
