<?php
namespace Shop\Mapper\Customer;

use Application\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class Address extends AbstractMapper
{
    protected $table = 'customerPrefix';
    protected $primary = 'prefixId';
    protected $model = 'Shop\Model\Customer\Prefix';
    protected $hydrator = 'Shop\Hydrator\Customer\Prefix';
    
}
