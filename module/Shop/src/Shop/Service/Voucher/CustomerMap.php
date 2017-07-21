<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Service\Voucher;

use Shop\Model\Customer\Customer;
use Shop\Model\Voucher\Code;
use Shop\Model\Voucher\CustomerMap as CustomerMapModel;
use UthandoCommon\Service\AbstractMapperService;

/**
 * Class CustomerMap
 * @package Shop\Service\Voucher
 */
class CustomerMap extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopVoucherCustomerMap';

    /**
     * @var array
     */
    protected $tags = [
        'voucher',
    ];

    /**
     * @param Code $voucher
     * @param Customer $customer
     * @return int
     */
    public function updateCustomerCount(Code $voucher, Customer $customer)
    {

        /* @var CustomerMapModel $map */
        $map = $this->getMapper()
            ->getByVoucherAndCustomerId(
                $voucher->getVoucherId(),
                $customer->getCustomerId()
            );

        if (!$map->getCustomerId()) {
            $map->setCustomerId($customer->getCustomerId());

        }

        $count = $map->getCount() + 1;
        $map->setCount($count);
        ;
        return $this->save($map);
    }

}