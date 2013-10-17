<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class CustomerDeliveryAddress extends AbstractMapper
{
    protected $table = 'customerDeliveryAddress';
    protected $primary = 'customerDeliveryAddressId';
    protected $model = 'Shop\Model\CustomerDeliveryAddress';
    protected $hydrator = 'Shop\Hydrator\CustomerDeliveryAddress';
}
