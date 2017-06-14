<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Validator;

use Shop\Mapper\Voucher\Code as CodeMapper;
use Shop\Mapper\Voucher\CustomerMap as CustomerMapMapper;
use Shop\Model\Customer\Customer;
use Shop\Model\Order\AbstractOrderCollection;
use Shop\Model\Order\LineInterface;
use Shop\Model\Voucher\Code;
use Shop\Model\Voucher\CustomerMap;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\AbstractValidator;

class Voucher extends AbstractValidator implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    const EXPIRED               = 'expired';
    const INVALID_CATEGORY      = 'invalidCategory';
    const INVALID_MINIMUM       = 'invalidMinimum';
    const INVALID_REDEEM        = 'invalidRedeem';
    const INVALID_VOUCHER       = 'invalidVoucher';
    const INVALID_ZONE          = 'invalidZone';
    const LIMITED_EDITION       = 'limitedEdition';
    const NOT_ACTIVE            = 'notActive';
    const OUT_OF_DATE_VOUCHER   = 'outOfDateVoucher';
    const USER_LIMIT_REACHED    = 'userLimitReached';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::EXPIRED               => 'This voucher has expired',
        self::INVALID_CATEGORY      => 'There are no qualifying products in your order.',
        self::INVALID_MINIMUM       => 'Your order total is not enough for you to qualify for this voucher code',
        self::INVALID_REDEEM        => 'This Voucher can be only redeemed at one of our fairs.',
        self::INVALID_VOUCHER       => 'This Voucher is not valid.',
        self::INVALID_ZONE          => 'This voucher is not for use in your country.',
        self::LIMITED_EDITION       => 'This was a limited edition voucher code, there are no more instances of that code left',
        self::NOT_ACTIVE            => 'The voucher code you entered is no longer active.',
        self::OUT_OF_DATE_VOUCHER   => 'This Voucher is out of date.',
        self::USER_LIMIT_REACHED    => 'You have reached the maximum number of uses of this voucher code.',
    ];

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var AbstractOrderCollection
     */
    protected $cart;

    /**
     * @param string $code
     * @return null|Code
     */
    public function getVoucher($code)
    {
        /* @var $mapper CodeMapper */
        $mapper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoMapperManager')
            ->get('ShopVoucherCode', [
                'model'     => 'ShopVoucherCode',
                'hydrator'  => 'ShopVoucherCode',
            ]);
        $voucher = $mapper->getVoucherByCode($code);

        return $voucher;
    }

    /**
     * @param $voucherId
     * @return null|CustomerMap
     */
    public function getCustomerMap($voucherId)
    {
        /* @var $mapper CustomerMapMapper */
        $mapper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoMapperManager')
            ->get(CustomerMapMapper::class, [
                'model'     => CustomerMap::class,
                'hydrator'  => ClassMethods::class,
            ]);
        $customerMap = $mapper->getByVoucherAndCustomerId(
            $voucherId,
            $this->getCustomer()->getCustomerId()
        );

        return $customerMap;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return Voucher
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return AbstractOrderCollection
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param AbstractOrderCollection $cart
     * @return Voucher
     */
    public function setCart(AbstractOrderCollection $cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @param mixed $value
     * @param null $context
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $voucher = $this->getVoucher($value);

        if (!$voucher instanceof Code) {
            $this->error(self::INVALID_VOUCHER);
            return false;
        }

        if (!$value === $voucher->getCode()) {
            $this->error(self::INVALID_VOUCHER);
            return false;
        }

        // not active
        if (!$voucher->isActive()) {
            $this->error(self::NOT_ACTIVE);
            return false;
        }

        // not allowed on website
        if ($voucher->getRedeemable() === Code::REDEEM_FAIR) {
            $this->error(self::INVALID_REDEEM);
            return false;
        }

        // get the the time
        $now = new \DateTime();

        // set start and end time of voucher
        $voucher->getStartDate()->setTime(00,00,00);
        $voucher->getExpiry()->setTime(23,59,59);

        // out of date
        if ($now->getTimestamp() < $voucher->getStartDate()->getTimestamp()) {
            $this->error(self::OUT_OF_DATE_VOUCHER);
            return false;
        }

        if (
            $voucher->getExpiry() instanceof \DateTime &&
            $now->getTimestamp() > $voucher->getExpiry()->getTimestamp()
        ) {
            $this->error(self::EXPIRED);
            return false;
        }

        // limited voucher
        if ($voucher->getQuantity() === 0) {
            $this->error(self::LIMITED_EDITION);
            return false;
        }

        if ($this->getCart() instanceof AbstractOrderCollection) {

            // minimum total
            if ($voucher->getMinCartCost() > 0 && $this->getCart()->getSubTotal() < $voucher->getMinCartCost()) {
                $this->error(self::INVALID_MINIMUM);
                return false;
            }

            // check for qualifying categories
            $catArray = [];

            /* @var LineInterface $item */
            foreach ($this->getCart() as $item) {
                $catArray[] = $item->getMetadata()->getCategory()->getProductCategoryId();
            }

            if (empty(array_intersect($catArray, $voucher->getProductCategories()->toArray()))) {
                $this->error(self::INVALID_CATEGORY);
                return false;
            }
        }

        if ($this->getCustomer() instanceof Customer) {

            $customerMap    = $this->getCustomerMap($voucher->getVoucherId());
            $zone           = $this->getCustomer()->getDeliveryAddress()->getCountry()->getPostZoneId();

            // check customer zone
            if (!in_array($zone, $voucher->getZones()->toArray())) {
                $this->error(self::INVALID_ZONE);
                return false;
            }

            // check customer hasn't used all vouchers
            if ($voucher->isLimitCustomer() && $customerMap->getCount() === $voucher->getNoPerCustomer()) {
                $this->error(self::USER_LIMIT_REACHED);
                return false;
            }
        }

        return true;
    }
}
