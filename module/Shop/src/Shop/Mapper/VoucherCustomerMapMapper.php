<?php

namespace Shop\Mapper;

use Shop\Model\VoucherCustomerMapModel as CustomerMapModel;
use Common\Mapper\AbstractDbMapper;

/**
 * Class CustomerMap
 *
 * @package Shop\Mapper
 */
class VoucherCustomerMapMapper extends AbstractDbMapper
{
    /**
     * @var string
     */
    protected $table = 'voucherCustomerMap';

    /**
     * @var string
     */
    protected $primary = 'id';

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