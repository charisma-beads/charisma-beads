<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;

class Size extends AbstractDbMapper
{
	protected $table = 'productSize';
	protected $primary = 'productSizeId';
}
