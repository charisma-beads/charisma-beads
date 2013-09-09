<?php
namespace Shop\Model\DbTable\Product;

use Application\Model\DbTable\AbstractTable;

class Category extends AbstractTable
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
	protected $rowClass = 'Shop\Model\Entity\Product\Category';
}
