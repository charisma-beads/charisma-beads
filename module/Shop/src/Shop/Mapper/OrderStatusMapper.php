<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Status
 *
 * @package Shop\Mapper
 */
class OrderStatusMapper extends AbstractDbMapper
{
    protected $table = 'orderStatus';
    protected $primary = 'orderStatusId';
    
    public function getStatusByName($status)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderStatus', $status);
        $resultSet = $this->fetchResult($select);
        $row = $resultSet->current();
        return $row;
    }
}
