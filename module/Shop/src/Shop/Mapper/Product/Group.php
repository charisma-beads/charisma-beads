<?php
namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractMapper;

class Group extends AbstractMapper
{
    protected $table = 'productGroup';
    protected $primary = 'productGroupId';
}
