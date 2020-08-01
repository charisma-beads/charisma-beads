<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Prefix
 *
 * @package Shop\Mapper
 */
class CustomerPrefixMapper extends AbstractDbMapper
{
    protected $table = 'customerPrefix';
    protected $primary = 'prefixId';
}
