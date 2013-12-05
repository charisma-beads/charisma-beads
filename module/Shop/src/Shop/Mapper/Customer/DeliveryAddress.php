<?php
namespace Shop\Mapper\Customer;

use Application\Mapper\AbstractMapper;

class DeliveryAddress extends AbstractMapper
{
    protected $table = 'customerDeliveryAddress';
    protected $primary = 'customerDeliveryAddressId';
    protected $model = 'Shop\Model\Customer\DeliveryAddress';
    protected $hydrator = 'Shop\Hydrator\Customer\DeliveryAddress';
}
