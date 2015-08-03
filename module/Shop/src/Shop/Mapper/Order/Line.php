<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Order;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Line
 *
 * @package Shop\Mapper\Order
 */
class Line extends AbstractDbMapper
{
    protected $table = 'orderLine';
    protected $primary = 'orderLineId';
    
    public function getOrderLinesByOrderId($id)
    {
        $select = $this->getSelect();
        $select->where->equalTo('orderId', $id);
        $select = $this->setSortOrder($select, 'sortOrder');
        return $this->fetchResult($select);
    }
}
