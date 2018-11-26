<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\View;

use Shop\Model\OrderModel;
use Zend\Form\View\Helper\AbstractHelper;

/**
 * Class OrderStatus
 *
 * @package Shop\View
 */
class OrderStatus extends AbstractHelper
{
    /**
     * @var array
     */
    protected $allowedStatuses = [
        'Pending',
        'Waiting for Payment',
        'Paypal Payment Pending',
        'Cheque Payment Pending',
        'Card Payment Pending',
    ];

    /**
     * @param OrderModel $order
     * @return bool
     */
    public function __invoke(OrderModel $order)
    {
        return $this->isAllowedStatus(
            $order->getOrderStatus()->getOrderStatus()
        );
    }

    /**
     * @param $status
     * @return bool
     */
    public function isAllowedStatus($status)
    {
        return in_array($status, $this->allowedStatuses);
    }
}
