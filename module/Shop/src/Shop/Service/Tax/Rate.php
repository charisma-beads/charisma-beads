<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Tax;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Rate
 *
 * @package Shop\Service\Tax
 */
class Rate extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopTaxRate';
    
    protected $tags = [
        'tax-rate',
    ];
    
}
