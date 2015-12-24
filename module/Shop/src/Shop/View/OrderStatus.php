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

use Shop\Model\Order\Order;
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
        'Waiting for Payment',
        'Paypal Payment Pending',
        'Cheque Payment Pending',
        'Card Payment Pending',
    ];

    /**
     * @param Order $order
     * @return bool
     */
    public function __invoke(Order $order)
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
