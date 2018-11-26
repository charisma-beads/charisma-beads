<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Payment
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Service;

use PayPal\Api\Payment;
use Shop\Model\OrderModel;
use Shop\ShopException;

/**
 * Class PaymentException
 *
 * @package Shop\Service
 */
class PaymentException extends ShopException
{
    /**
     * @var OrderModel
     */
    protected  $order;

    /**
     * @var Payment
     */
    protected $payment;

    /**
     * @return OrderModel
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param OrderModel $order
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
