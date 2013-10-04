<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class ProductImage extends AbstractMapper
{
	protected $table = 'productImage';
	protected $primary = 'productImageId';
	protected $model = 'Shop\Model\ProductImage';
	protected $hydrator = 'Shop\Hydrator\ProductImage';
}
