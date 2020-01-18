<?php


namespace Shop\Mapper;


use UthandoCommon\Mapper\AbstractDbMapper;

class ProductAvailabilityMapper extends AbstractDbMapper
{
    protected $table = 'product_availability';
    protected $primary = 'id';
}