<?php
namespace Shop\Mapper;

use Application\Mapper\AbstractMapper;

class CustomerBillingAddress extends AbstractMapper
{
    protected $table = 'customerBillingAddress';
    protected $primary = 'customerBillingAddressId';
    protected $model = 'Shop\Model\CustomerBillingAddress';
    protected $hydrator = 'Shop\Hydrator\CustomerBillingAddress';
    
}
