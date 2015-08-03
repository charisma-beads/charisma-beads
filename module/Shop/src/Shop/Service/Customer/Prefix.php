<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Customer;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Prefix
 *
 * @package Shop\Service\Customer
 */
class Prefix extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCustomerPrefix';
    
    protected $tags = [
        'customer-prefix',
    ];
}
