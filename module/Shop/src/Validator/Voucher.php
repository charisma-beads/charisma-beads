<?php

namespace Shop\Validator;

use Shop\Hydrator\VoucherCodeHydrator;
use Shop\Hydrator\VoucherCustomerMapHydrator;
use Shop\Mapper\VoucherCodeMapper;
use Shop\Mapper\VoucherCustomerMapMapper;
use Shop\Model\CountryModel;
use Shop\Model\CustomerModel;
use Shop\Model\AbstractOrderCollection;
use Shop\Model\OrderLineInterface;
use Shop\Model\VoucherCodeModel;
use Shop\Model\VoucherCustomerMapModel;
use Common\Mapper\MapperManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Validator\AbstractValidator;

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
     * @var CustomerModel
     */
    protected $customer;

    /**
     * @var AbstractOrderCollection
     */
    protected $orderModel;

    /**
     * @var CountryModel
     */
    protected $country;

    /**
     * @param string $code
     * @return null|VoucherCodeModel
     */
    public function getVoucher($code)
    {
        /* @var $mapper VoucherCodeMapper */
        $mapper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(MapperManager::class)
            ->get(VoucherCodeMapper::class, [
                'model'     => VoucherCodeModel::class,
                'hydrator'  => VoucherCodeHydrator::class,
            ]);
        $voucher = $mapper->getVoucherByCode($code);

        return $voucher;
    }

    /**
     * @param $voucherId
     * @return null|VoucherCustomerMapModel
     */
    public function getCustomerMap($voucherId)
    {
        /* @var $mapper VoucherCustomerMapMapper */
        $mapper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(MapperManager::class)
            ->get(VoucherCustomerMapMapper::class, [
                'model'     => VoucherCustomerMapModel::class,
                'hydrator'  => VoucherCustomerMapHydrator::class,
            ]);


        $customerMap = $mapper->getByVoucherAndCustomerId(
            $voucherId,
            $this->getCustomer()->getCustomerId()
        );

        return $customerMap;
    }

    /**
     * @return CustomerModel
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param CustomerModel $customer
     * @return Voucher
     */
    public function setCustomer($customer)
    {
        if ($customer instanceof CustomerModel) {
            $this->customer = $customer;
            $this->setCountry($customer->getDeliveryAddress()->getCountry());
        }

        return $this;
    }

    /**
     * @return CountryModel
     */
    public function getCountry()
    {
        if ($this->getCustomer() instanceof CustomerModel) {
            $country = $this->getCustomer()->getDeliveryAddress()->getCountry();
        } else {
            $country = $this->country;
        }

        return $country;
    }

    /**
     * @param CountryModel $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return AbstractOrderCollection
     */
    public function getOrderModel()
    {
        return $this->orderModel;
    }

    /**
     * @param AbstractOrderCollection $orderModel
     * @return Voucher
     */
    public function setOrderModel(AbstractOrderCollection $orderModel)
    {
        $this->orderModel = $orderModel;
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


        if (!$voucher instanceof VoucherCodeModel) {
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
        if ($voucher->getRedeemable() === VoucherCodeModel::REDEEM_FAIR) {
            $this->error(self::INVALID_REDEEM);
            return false;
        }

        // get the the time
        $now = new \DateTime();

        // set start time of voucher
        $voucher->getStartDate()->setTime(00,00,00);

        // out of date
        if ($now->getTimestamp() < $voucher->getStartDate()->getTimestamp()) {
            $this->error(self::OUT_OF_DATE_VOUCHER);
            return false;
        }

        if ($voucher->getExpiry() instanceof \DateTime) {
            // set end time of voucher
            $voucher->getExpiry()->setTime(23,59,59);

            if ($now->getTimestamp() > $voucher->getExpiry()->getTimestamp()) {
                $this->error(self::EXPIRED);
                return false;
            }
        }

        // limited voucher
        if ($voucher->getQuantity() === 0) {
            $this->error(self::LIMITED_EDITION);
            return false;
        }

        if ($this->getCountry() instanceof CountryModel) {
            $zone = $this->getCountry()->getPostZoneId();

            // check valid zone
            if (!in_array($zone, $voucher->getZones()->toArray())) {
                $this->error(self::INVALID_ZONE);
                return false;
            }
        }

        if ($this->getOrderModel() instanceof AbstractOrderCollection) {

            // minimum total
            if ($voucher->getMinCartCost() > 0 && $this->getOrderModel()->getSubTotal() < $voucher->getMinCartCost()) {
                $this->error(self::INVALID_MINIMUM);
                return false;
            }

            // check for qualifying categories
            $catArray = [];

            /* @var OrderLineInterface $item */
            foreach ($this->getOrderModel() as $item) {
                $catArray[] = $item->getMetadata()->getCategory()->getProductCategoryId();
            }

            if (empty(array_intersect($catArray, $voucher->getProductCategories()->toArray()))) {
                $this->error(self::INVALID_CATEGORY);
                return false;
            }
        }



        if ($this->getCustomer() instanceof CustomerModel) {

            $customerMap    = $this->getCustomerMap($voucher->getVoucherId());

            // check customer hasn't used all vouchers
            if ($voucher->isLimitCustomer() && $customerMap->getCount() >= $voucher->getNoPerCustomer()) {
                $this->error(self::USER_LIMIT_REACHED);
                return false;
            }
        }

        return true;
    }
}
