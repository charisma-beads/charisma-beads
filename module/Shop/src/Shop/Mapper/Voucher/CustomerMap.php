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

use Shop\Model\Voucher\CustomerMap as CustomerMapModel;
use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class CustomerMap
 *
 * @package Shop\Mapper\Voucher
 */
class CustomerMap extends AbstractDbMapper
{
    /**
     * @var string
     */
    protected $table = 'voucherCustomerMap';

    /**
     * @var string
     */
    protected $primary = 'voucherId';

    /**
     * @param $voucherId
     * @param $customerId
     * @return CustomerMapModel|null
     */
    public function getByVoucherAndCustomerId($voucherId, $customerId)
    {
        $select = $this->getSelect();
        $select->where
            ->equalTo('voucherId', $voucherId)
            ->and
            ->equalTo('customerId', $customerId);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();

        if (!$row) {
            $row = new CustomerMapModel();
        }

        return $row;
    }
}