<?php

namespace Shop\Model;

use DateTime;
use Common\Model\ModelInterface;
use Common\Model\Model;

/**
 * Class CreditCard
 *
 * @package Shop\Model\Payment
 */
class CreditCardModel implements ModelInterface
{
    const CREDIT_CARD_VISA          = 'Visa/Delta/Electron';
    const CREDIT_CARD_MASTERCARD    = 'MasterCard/Eurocard';
    const CREDIT_CARD_DISCOVER      = 'Discover';
    const CREDIT_CARD_MAESTRO       = 'Switch/Maestro';
    const CREDIT_CARD_SOLO          = 'Solo';
    
    public static $creditCardName = [
        'v'   => self::CREDIT_CARD_VISA,
        'm'   => self::CREDIT_CARD_MASTERCARD,
        'd'   => self::CREDIT_CARD_DISCOVER,
        'sm'  => self::CREDIT_CARD_MAESTRO,
        's'   => self::CREDIT_CARD_SOLO,
    ];
    
    use Model;
    
    /**
     * @var int
     */
    protected $orderId;
    
    /**
     * @var float
     */
    protected $total;
    
    /**
     * @var string
     */
    protected $ccType;
    
    /**
     * @var string
     */
    protected $ccName;
    
    /**
     * @var int
     */
    protected $ccNumber;
    
    /**
     * @var int
     */
    protected $cvv2;
    
    /**
     * @var DateTime
     */
    protected $ccExpiryDate;
    
    /**
     * @var DateTime
     */
    protected $ccStartDate;
    
    /**
     * @var int
     */
    protected $ccIssueNumber;
    
    /**
     * @var CustomerAddressModel
     */
    protected $address;
 
    /**
     * @return number $orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param number $orderId
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return number $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param number $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return string $ccType
     */
    public function getCcType()
    {
        return ($this->ccType) ? self::$creditCardName[$this->ccType] : null;
    }

    /**
     * @param int $ccType
     * @return $this
     */
    public function setCcType($ccType)
    {
        $this->ccType = $ccType;
        return $this;
    }

    /**
     * @return string $ccName
     */
    public function getCcName()
    {
        return $this->ccName;
    }

     /**
     * @param string $ccName
     * @return $this
     */
    public function setCcName($ccName)
    {
        $this->ccName = $ccName;
        return $this;
    }

    /**
     * @return number $ccNumber
     */
    public function getCcNumber()
    {
        return $this->ccNumber;
    }

    /**
     * @param number $ccNumber
     * @return $this
     */
    public function setCcNumber($ccNumber)
    {
        $this->ccNumber = $ccNumber;
        return $this;
    }

    /**
     * @return number $ccv2
     */
    public function getCvv2()
    {
        return $this->cvv2;
    }

    /**
     * @param number $cvv2
     * @return $this
     */
    public function setCvv2($cvv2)
    {
        $this->cvv2 = $cvv2;
        return $this;
    }

    /**
     * @return DateTime $ccExpiryDate
     */
    public function getCcExpiryDate()
    {
        return $this->ccExpiryDate;
    }

    /**
     * @param DateTime $ccExpiryDate
     * @return $this
     */
    public function setCcExpiryDate($ccExpiryDate)
    {
        $this->ccExpiryDate = $ccExpiryDate;
        return $this;
    }

    /**
     * @return DateTime $ccStartDate
     */
    public function getCcStartDate()
    {
        return $this->ccStartDate;
    }

    /**
     * @param DateTime $ccStartDate
     * @return $this
     */
    public function setCcStartDate($ccStartDate)
    {
        $this->ccStartDate = $ccStartDate;
        return $this;
    }

    /**
     * @return number $ccIssueNumber
     */
    public function getCcIssueNumber()
    {
        return $this->ccIssueNumber;
    }

    /**
     * @param number $ccIssueNumber
     * @return $this
     */
    public function setCcIssueNumber($ccIssueNumber)
    {
        $this->ccIssueNumber = $ccIssueNumber;
        return $this;
    }

    /**
     * @return CustomerAddressModel $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param CustomerAddressModel $address
     * @return $this
     */
    public function setAddress(CustomerAddressModel $address)
    {
        $this->address = $address;
        return $this;
    }
}
