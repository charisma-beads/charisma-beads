<?php
use Shop\Service\Cart\Cart;

/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Service\Voucher;

use Shop\Mapper\Product\Category;
use Shop\Model\Product\Category as CategoryModel;
use Shop\Model\Voucher\Code as CodeModel;
use Shop\Model\Voucher\Code as VoucherCode;
use Shop\Model\Voucher\ProductCategory;
use Shop\Service\Order\AbstractOrder;
use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;

/**
 * Class Code
 *
 * @package Shop\Service\Voucher
 * @method \Shop\Mapper\Voucher\Code getMapper($mapperClass = null, array $options = [])
 */
class Code extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopVoucherCode';

    /**
     * @var array
     */
    protected $tags = [
        'voucher',
    ];

    /**
     * setup events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'setupForm']);

        $this->getEventManager()->attach([
            'pre.save',
        ], [$this, 'checkChildCategories']);
    }

    /**
     * @param $code
     * @return null|CodeModel
     */
    public function getVoucherByCode($code)
    {
        \ChromePhp::info($code);
        return $this->getMapper()->getVoucherByCode($code);
    }

    /**
     * @param Event $e
     */
    public function checkChildCategories(Event $e)
    {
        /* @var CodeModel $data */
        $data = $e->getParam('data');

        /* @var $mapper Category */
        $mapper = $this->getMapper('ShopProductCategory');

        $categories = [];

        /* @var ProductCategory $productCategory */
        foreach ($data->getProductCategories() as $productCategory) {
            $childCategories = $mapper->getSubCategoriesByParentId($productCategory->getCategoryId());

            /* @var CategoryModel $category */
            foreach ($childCategories as $category) {
                $categories[] = $category->getProductCategoryId();
            }
        }

        $data->getProductCategories()->fromArray($categories);
        $e->setParam('data', $data);
    }

    /**
     * @param VoucherCode $voucher
     * @param AbstractOrder $service
     * @return float|int
     */
    public function doDiscount(VoucherCode $voucher, AbstractOrder $service)
    {
        // qualified items
        $items = [];
        $voucherCategories = $voucher->getProductCategories()->toArray();

        /* @var \Shop\Model\Cart\Item $item */
        foreach ($service->getOrderModel() as $key => $item) {
            if (in_array($item->getMetadata()->getCategory()->getProductCategoryId(), $voucherCategories)) {
                $items[] = $item;
            }
        }

        $discount = 0;

        switch($voucher->getDiscountOperation()) {
            case VoucherCode::DISCOUNT_SUBTOTAL:
                $subTotal = $service->getSubTotal();

                if ($voucher->getDiscountAmount() > $subTotal) {
                    $discount = $subTotal;
                } else {
                    $discount = $voucher->getDiscountAmount();
                }
                break;
            case VoucherCode::DISCOUNT_SUBTOTAL_PERCENTAGE:
                $subTotal = $service->getSubTotal();
                $discount = (($subTotal) / 100) * $voucher->getDiscountAmount();
                break;
            case VoucherCode::DISCOUNT_CATEGORY:
                $catSubTotal = 0;

                foreach ($items as $item) {
                    $catSubTotal += $item->getPrice() * $item->getQuantity();
                    $discount += $voucher->getDiscountAmount() * $item->getQuantity();
                }

                if ($discount > $catSubTotal) {
                    $discount = $catSubTotal;
                }
                break;
            case VoucherCode::DISCOUNT_CATEGORY_PERCENTAGE:
                $catSubTotal = 0;

                foreach ($items as $item) {
                    $catSubTotal += $item->getPrice() * $item->getQuantity();
                }

                $discount = (($catSubTotal) / 100) * $voucher->getDiscountAmount();
                break;
            case VoucherCode::DISCOUNT_SHIPPING:
                $shipping = $service->getShippingCost() + $service->getShippingTax();

                if ($voucher->getDiscountAmount() > $shipping) {
                    $discount = $shipping;
                } else {
                    $discount = $voucher->getDiscountAmount();
                }
                break;
            case VoucherCode::DISCOUNT_SHIPPING_PERCENTAGE:
                $shipping = $service->getShippingCost() + $service->getShippingTax();
                $discount = (($shipping) / 100) * $voucher->getDiscountAmount();
                break;
        }

        return $discount;
    }

    /**
     * @param Event $e
     */
    public function setupForm(Event $e)
    {
        $form = $e->getParam('form');
        $model = $e->getParam('model');
        $post = $e->getParam('post');

        $code = ($model instanceof CodeModel && $model->getCode() === $post['code']) ? $model->getCode() : null;

        /* @var $inputFilter \Shop\InputFilter\Voucher\Code */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addNoRecordExists($code);

        $hydrator = $form->getHydrator();
        /* @var DateTime $dateTimeStrategy */
        $dateTimeStrategy = $hydrator->getStrategy('startDate');
        $dateTimeStrategy->setHydrateFormat('d/m/Y');
        $dateTimeStrategy = $hydrator->getStrategy('expiry');
        $dateTimeStrategy->setHydrateFormat('d/m/Y');
    }
}