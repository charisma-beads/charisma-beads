<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Size
 *
 * @package Shop\Service\Product
 */
class Size extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductSize';
    
    protected $tags = [
        'size',
    ];
}
