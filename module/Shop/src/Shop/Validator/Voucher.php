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

use Shop\Mapper\Product\Category;
use Shop\Mapper\Voucher\Code as CodeMapper;
use Shop\Mapper\Voucher\CustomerMap as CustomerMapMapper;
use Shop\Model\Customer\Customer;
use Shop\Model\Order\AbstractOrderCollection;
use Shop\Model\Order\LineInterface;
use Shop\Model\Product\Category as CategoryModel;
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
        self::INVALID_MINIMUM       => 'Your order total is not enough for your order to qualify for this voucher code',
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
    public function getVoucher($code): ?Code
    {
        /* @var $mapper CodeMapper */
        $mapper = $this->getServiceLocator()
            ->get('UthandoMapperManager')
            ->get('ShopVoucherCode', [
                'model'     => 'ShopVoucherCode',
                'hydrator'  => 'ShopVoucherCode',
            ]);
        $voucher = $mapper->getVoucherByCode($code);

        return $voucher;
    }

    /**
     * @return null|CustomerMap
     */
    public function getCustomerMap(): ?CustomerMap
    {
        /* @var $mapper CustomerMapMapper */
        $mapper = $this->getServiceLocator()
            ->get('UthandoMapperManager')
            ->get(CustomerMapMapper::class, [
                'model'     => CustomerMap::class,
                'hydrator'  => ClassMethods::class,
            ]);
        $customerMap = $mapper->getByVoucherAndCustomerId(
            $this->getVoucher()->getVoucherId(),
            $this->getCustomer()->getCustomerId()
        );

        return $customerMap;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return Voucher
     */
    public function setCustomer(Customer $customer): Voucher
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return AbstractOrderCollection
     */
    public function getCart(): AbstractOrderCollection
    {
        return $this->cart;
    }

    /**
     * @param AbstractOrderCollection $cart
     * @return Voucher
     */
    public function setCart(AbstractOrderCollection $cart): Voucher
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @param $parentId
     * @return array
     */
    public function getChildCategories($parentId): array
    {
        /* @var $mapper Category */
        $mapper = $this->getServiceLocator()
            ->get('UthandoMapperManager')
            ->get('ShopProductCategory', [
                'model'     => 'ShopProductCategory',
                'hydrator'  => 'ShopProductCategory',
            ]);

        $childCategories = $mapper->getSubCategoriesByParentId($parentId);

        $categories = [];

        /* @var CategoryModel $category */
        foreach ($childCategories as $category) {
            $categories[] = $category->getProductCategoryId();
        }

        return $categories;
    }

    /**
     * @param mixed $value
     * @param null $context
     * @return bool
     */
    public function isValid($value, $context = null): bool
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
            $this->$this->error(self::NOT_ACTIVE);
            return false;
        }

        // not allowed on website
        if ($voucher->getRedeemable() === Code::REDEEM_FAIR) {
            $this->error(self::INVALID_REDEEM);
            return false;
        }

        // get the start and end of day today.
        $todayStart = new \DateTime('midnight today');
        $todayEnd   = new \DateTime('midnight tomorrow');

        // out of date
        if ($todayStart->getTimestamp() < $voucher->getStartDate()->getTimestamp()) {
            $this->error(self::OUT_OF_DATE_VOUCHER);
            return false;
        }

        if (
            $voucher->getExpiry() instanceof \DateTime &&
            $todayEnd->getTimestamp() > $voucher->getExpiry()->getTimestamp()
        ) {
            $this->error(self::EXPIRED);
            return false;
        }

        // limited voucher
        if ($voucher->getQuantity() === 0) {
            $this->error(self::LIMITED_EDITION);
            return false;
        }

        if ($this->getCart() instanceof AbstractOrderCollection && $voucher->getMinCartCost() > 0) {

            // minimum total
            if ($this->getCart()->getSubTotal() < $voucher->getMinCartCost()) {
                $this->error(self::INVALID_MINIMUM);
                return false;
            }

            // check for qualifying categories
            $catArray = [];

            /* @var LineInterface $item */
            foreach ($this->getCart() as $item) {
                $catArray[] = $item->getMetadata()->getCategory()->getProductCategoryId();

                if ($item->getMetadata()->getCategory()->hasChildren()) {
                    array_merge(
                        $catArray,
                        $this->getChildCategories(
                            $item->getMetadata()
                                ->getCategory()
                                ->getProductCategoryId()
                        )
                    );
                }
            }

            if (!in_array($voucher->getProductCategories()->toArray(), $catArray)) {
                $this->error(self::INVALID_CATEGORY);
                return false;
            }

        }

        if ($this->getCustomer() instanceof Customer) {
            $customerMap = $this->getCustomerMap();

            // check customer zone
            if (in_array($this->getCustomer()->getDeliveryAddress()->getCountryId(), $voucher->getZones()->toArray())) {
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
