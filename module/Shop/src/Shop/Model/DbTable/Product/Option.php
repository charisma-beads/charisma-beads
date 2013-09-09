<?php
namespace Shop\Model\DbTable\Product;

use Application\Model\DbTable\AbstractTable;

class Option extends AbstractTable
{
	protected $table = 'productOption';
	protected $primary = 'productOptionId';
	protected $rowClass = 'Shop\Entity\Product\Option';
}
