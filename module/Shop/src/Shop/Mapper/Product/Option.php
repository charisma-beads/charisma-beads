<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;

class Option extends AbstractDbMapper
{
	protected $table = 'productOption';
	protected $primary = 'productOptionId';
}
