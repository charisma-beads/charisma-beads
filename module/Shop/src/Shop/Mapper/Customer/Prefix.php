<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Customer;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Prefix
 *
 * @package Shop\Mapper\Customer
 */
class Prefix extends AbstractDbMapper
{
    protected $table = 'customerPrefix';
    protected $primary = 'prefixId';
}
