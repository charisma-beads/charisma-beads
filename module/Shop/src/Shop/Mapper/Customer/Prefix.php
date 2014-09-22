<?php
namespace Shop\Mapper\Customer;

use UthandoCommon\Mapper\AbstractMapper;

class Prefix extends AbstractMapper
{
    protected $table = 'customerPrefix';
    protected $primary = 'prefixId';
}
