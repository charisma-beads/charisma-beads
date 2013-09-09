<?php
namespace Shop\Model\DbTable;

use Application\Model\DbTable\AbstractTable;

class Product extends AbstractTable
{
	protected $table = 'product';
	protected $primary = 'prodctId';
	protected $rowClass = 'Shop\Model\Entity\Product';
}
