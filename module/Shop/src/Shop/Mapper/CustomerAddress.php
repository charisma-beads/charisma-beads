<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class CustomerAddress extends AbstractMapper
{
    protected $table = 'customerAddress';
    protected $primary = 'customerAddressId';
    protected $model = 'Shop\Model\CustomerAddress';
    protected $hydrator = 'Shop\Hydrator\CustomerAddress';
}
