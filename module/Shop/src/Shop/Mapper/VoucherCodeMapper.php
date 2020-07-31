<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Code
 *
 * @package Shop\Mapper
 */
class VoucherCodeMapper extends AbstractDbMapper
{
    /**
     * @var string
     */
    protected $table = 'voucherCodes';

    /**
     * @var string
     */
    protected $primary = 'voucherId';

    /**
     * @param $code
     * @return \Shop\Model\VoucherCodeModel|null
     */
    public function getVoucherByCode($code)
    {
        $code = strtoupper($code);

        $select = $this->getSelect();
        $select->where
            ->equalTo('code', $code);

        $result = $this->fetchResult($select);
        $row    = $result->current();

        return $row;
    }
}