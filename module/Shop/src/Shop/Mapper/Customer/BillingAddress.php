<?php
namespace Shop\Mapper\Customer;

use Application\Mapper\AbstractMapper;

class BillingAddress extends AbstractMapper
{
    protected $table = 'customerBillingAddress';
    protected $primary = 'customerBillingAddressId';
    protected $model = 'Shop\Model\Customer\BillingAddress';
    protected $hydrator = 'Shop\Hydrator\Customer\BillingAddress';
    
}
