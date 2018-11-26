<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

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