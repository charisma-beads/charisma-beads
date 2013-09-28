<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class ProductOption extends AbstractMapper
{
	protected $table = 'productOption';
	protected $primary = 'productOptionId';
	protected $rowClass = 'Shop\Model\ProductOption';
}
