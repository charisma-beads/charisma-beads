<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Service;

use Shop\Hydrator\VoucherCustomerMapHydrator;
use Shop\Mapper\VoucherCustomerMapMapper;
use Shop\Model\CustomerModel;
use Shop\Model\VoucherCodeModel;
use Shop\Model\VoucherCustomerMapModel;
use Common\Service\AbstractMapperService;

/**
 * Class CustomerMap
 * @package Shop\Service
 */
class VoucherCustomerMapService extends AbstractMapperService
{
    protected $hydrator     = VoucherCustomerMapHydrator::class;
    protected $mapper       = VoucherCustomerMapMapper::class;
    protected $model        = VoucherCustomerMapModel::class;
    /**
     * @var array
     */
    protected $tags = [
        'voucher',
    ];

    /**
     * @param VoucherCodeModel $voucher
     * @param CustomerModel $customer
     * @return int
     * @throws \Common\Service\ServiceException
     */
    public function updateCustomerCount(VoucherCodeModel $voucher, CustomerModel $customer)
    {

        /* @var VoucherCustomerMapModel $map */
        $map = $this->getMapper()
            ->getByVoucherAndCustomerId(
                $voucher->getVoucherId(),
                $customer->getCustomerId()
            );

        if (!$map->getVoucherId()) {
            $map->setVoucherId($voucher->getVoucherId());
        }

        if (!$map->getCustomerId()) {
            $map->setCustomerId($customer->getCustomerId());
        }

        $count = $map->getCount() + 1;
        $map->setCount($count);

        return $this->save($map);
    }

}