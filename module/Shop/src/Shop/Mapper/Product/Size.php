<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Product;

use UthandoCommon\Mapper\AbstractDbMapper;

class Size extends AbstractDbMapper
{
	protected $table = 'productSize';
	protected $primary = 'productSizeId';
}
