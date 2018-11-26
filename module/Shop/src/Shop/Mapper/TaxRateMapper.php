<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Rate
 *
 * @package Shop\Mapper
 */
class TaxRateMapper extends AbstractDbMapper
{
	protected $table = 'taxRate';
	protected $primary = 'taxRateId';
	
}
