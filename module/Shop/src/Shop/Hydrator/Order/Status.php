<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Order;

use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Status
 *
 * @package Shop\Hydrator\Order
 */
class Status extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Order\Status $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'orderStatusId'    => $object->getOrderStatusId(),
            'orderStatus'      => $object->getOrderStatus(),
        ];
    }
}
