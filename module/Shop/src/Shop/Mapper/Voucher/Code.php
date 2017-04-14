<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Mapper\Voucher;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Code
 *
 * @package Shop\Mapper\Voucher
 */
class Code extends AbstractDbMapper
{
    /**
     * @var string
     */
    protected $table = 'voucherCodes';

    /**
     * @var string
     */
    protected $primary = 'voucherId';
}