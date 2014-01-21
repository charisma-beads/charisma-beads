<?php
namespace Shop\Mapper\Customer;

use Application\Mapper\AbstractMapper;

class Address extends AbstractMapper
{
    protected $table = 'customerAddress';
    protected $primary = 'customerAddressId';
    protected $model = 'Shop\Model\Customer\Address';
    protected $hydrator = 'Shop\Hydrator\Customer\Address';
    
}
