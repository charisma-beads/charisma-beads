<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Hydrator\CustomerPrefixHydrator;
use Shop\Mapper\CustomerPrefixMapper;
use Shop\Model\CustomerPrefixModel;
use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Prefix
 *
 * @package Shop\Service
 */
class CustomerPrefixService extends AbstractMapperService
{
    protected $hydrator     = CustomerPrefixHydrator::class;
    protected $mapper       = CustomerPrefixMapper::class;
    protected $model        = CustomerPrefixModel::class;
    
    protected $tags = [
        'customer-prefix',
    ];
}
