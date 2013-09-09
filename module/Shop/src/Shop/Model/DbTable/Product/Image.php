<?php
namespace Shop\Model\DbTable\Product;

use Application\Model\DbTable\AbstractTable;

class Image extends AbstractTable
{
	protected $table = 'productImage';
	protected $primary = 'productImageId';
	protected $rowClass = 'Shop\Model\Entity\Product\Image';
}
