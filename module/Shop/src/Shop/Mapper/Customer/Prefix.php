<?php
namespace Shop\Mapper\Customer;

use UthandoCommon\Mapper\AbstractDbMapper;

class Prefix extends AbstractDbMapper
{
    protected $table = 'customerPrefix';
    protected $primary = 'prefixId';
}
