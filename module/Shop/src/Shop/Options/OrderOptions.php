<?php

namespace Shop\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Class OrderOptions
 *
 * @package Shop\Options
 */
class OrderOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $creditCardPaymentEmail;

    /**
     * @var string
     */
    protected $orderEmail;

    /**
     * @var bool
     */
    protected $sendOrderToAdmin;

    /**
     * @var bool
     */
    protected $emailCustomerOnStatusChange;

    /**
     * @return string $creditCardPaymentEmail
     */
    public function getCreditCardPaymentEmail()
    {
        return $this->creditCardPaymentEmail;
    }

    /**
     * @param string $creditCardPaymentEmail
     * @return $this
     */
    public function setCreditCardPaymentEmail($creditCardPaymentEmail)
    {
        $this->creditCardPaymentEmail = $creditCardPaymentEmail;
        return $this;
    }

    /**
     * @return string $orderEmail
     */
    public function getOrderEmail()
    {
        return $this->orderEmail;
    }

    /**
     * @param string $orderEmail
     * @return $this
     */
    public function setOrderEmail($orderEmail)
    {
        $this->orderEmail = $orderEmail;
        return $this;
    }

    /**
     * @return boolean $sendOrderToAdmin
     */
    public function getSendOrderToAdmin()
    {
        return $this->sendOrderToAdmin;
    }

    /**
     * @param boolean $sendOrderToAdmin
     * @return $this
     */
    public function setSendOrderToAdmin($sendOrderToAdmin)
    {
        $this->sendOrderToAdmin = $sendOrderToAdmin;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEmailCustomerOnStatusChange()
    {
        return $this->emailCustomerOnStatusChange;
    }

    /**
     * @return boolean
     */
    public function getEmailCustomerOnStatusChange()
    {
        return $this->emailCustomerOnStatusChange;
    }

    /**
     * @param boolean $emailCustomerOnStatusChange
     * @return $this
     */
    public function setEmailCustomerOnStatusChange($emailCustomerOnStatusChange)
    {
        $this->emailCustomerOnStatusChange = (bool) $emailCustomerOnStatusChange;
        return $this;
    }

}