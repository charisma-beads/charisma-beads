<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Payment
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Service\Payment;

use PayPal\Api\Payment;
use Shop\Model\Order\Order;
use Shop\ShopException;

/**
 * Class PaymentException
 *
 * @package Shop\Service\Payment
 */
class PaymentException extends ShopException
{
    /**
     * @var Order
     */
    protected  $order;

    /**
     * @var Payment
     */
    protected $payment;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     * @return $this
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }
}
