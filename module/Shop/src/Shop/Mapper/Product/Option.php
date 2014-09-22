<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractMapper;

class Option extends AbstractMapper
{
	protected $table = 'productOption';
	protected $primary = 'productOptionId';
}
