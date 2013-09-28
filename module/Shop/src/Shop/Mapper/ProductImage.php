<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class ProductImage extends AbstractMapper
{
	protected $table = 'productImage';
	protected $primary = 'productImageId';
	protected $rowClass = 'Shop\Model\ProductImage';
}
