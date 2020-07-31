<?php

namespace Shop\Service;

use Shop\Hydrator\CustomerPrefixHydrator;
use Shop\Mapper\CustomerPrefixMapper;
use Shop\Model\CustomerPrefixModel;
use Common\Service\AbstractMapperService;

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
