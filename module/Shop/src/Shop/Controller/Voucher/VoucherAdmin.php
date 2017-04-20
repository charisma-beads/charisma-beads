<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Controller\Voucher;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class VoucherAdmin
 *
 * @package Shop\Controller\Voucher
 */
class VoucherAdmin extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'voucherId');
    protected $serviceName = 'ShopVoucherCode';
    protected $route = 'admin/shop/voucher';
}