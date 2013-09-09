<?php
namespace Shop\Model\DbTable\Product;

use Application\Model\DbTable\AbstractNestedSet;

class Category extends AbstractNestedSet
{
	protected $table = 'productCategory';
	protected $primary = 'productCategoryId';
	protected $rowClass = 'Shop\Model\Entity\Product\Category';
}
