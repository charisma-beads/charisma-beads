<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Status
 *
 * @package Shop\Hydrator
 */
class OrderStatusHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\OrderStatusModel $object
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
