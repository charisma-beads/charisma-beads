<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;

class Group extends AbstractDbMapper
{
    protected $table = 'productGroup';
    protected $primary = 'productGroupId';
}
