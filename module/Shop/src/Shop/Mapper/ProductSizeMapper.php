<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

class ProductSizeMapper extends AbstractDbMapper
{
	protected $table = 'productSize';
	protected $primary = 'productSizeId';
}
