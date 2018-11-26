<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Service;

use Shop\Form\VoucherCodeForm;
use Shop\Hydrator\VoucherCodeHydrator;
use Shop\InputFilter\VoucherCodeInputFilter;
use Shop\Mapper\VoucherCodeMapper;
use Shop\Model\VoucherCodeModel;
use Shop\Model\ProductCategoryModel;
use Shop\Model\VoucherProductCategoryModel;
use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;

/**
 * Class Code
 *
 * @package Shop\Service
 * @method \Shop\Mapper\VoucherCodeMapper getMapper($mapperClass = null, array $options = [])
 */
class VoucherCodeService extends AbstractMapperService
{
    protected $form         = VoucherCodeForm::class;
    protected $hydrator     = VoucherCodeHydrator::class;
    protected $inputFilter  = VoucherCodeInputFilter::class;
    protected $mapper       = VoucherCodeMapper::class;
    protected $model        = VoucherCodeModel::class;

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
     * @return null|VoucherCodeModel
     */
    public function getVoucherByCode($code)
    {
        return $this->getMapper()->getVoucherByCode($code);
    }

    /**
     * @param Event $e
     * @throws \UthandoCommon\Model\CollectionException
     */
    public function checkChildCategories(Event $e)
    {
        /* @var VoucherCodeModel $data */
        $data = $e->getParam('data');

        /* @var $service ProductCategoryService */
        $service = $this->getService(ProductCategoryService::class);

        $categories = [];

        /* @var VoucherProductCategoryModel $productCategory */
        foreach ($data->getProductCategories() as $productCategory) {

            $childCategories = $service->getCategoryChildrenIds($productCategory->getCategoryId());

            /* @var ProductCategoryModel $category */
            foreach ($childCategories as $categoryId) {
                $categories[] = $categoryId;
            }
        }

        $data->getProductCategories()->fromArray($categories);
        $e->setParam('data', $data);
    }

    /**
     * @param $voucherCode
     * @return bool|int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function updateVoucherCount($voucherCode)
    {
        $voucher = $this->getMapper()->getVoucherByCode($voucherCode);
        $qty     = $voucher->getQuantity();

        if ($qty > 0) {
            $qty = $qty - 1;
            $voucher->setQuantity($qty);
            return $this->save($voucher);
        }

        return false;
    }

    /**
     * @param VoucherCodeModel $voucher
     * @param AbstractOrderService $service
     * @return float|int
     */
    public function doDiscount(VoucherCodeModel $voucher, AbstractOrderService $service)
    {
        // qualified items
        $items = [];
        $voucherCategories = $voucher->getProductCategories()->toArray();

        /* @var \Shop\Model\CartItemModel $item */
        foreach ($service->getOrderModel() as $key => $item) {
            if (in_array($item->getMetadata()->getCategory()->getProductCategoryId(), $voucherCategories)) {
                $items[] = $item;
            }
        }

        $discount = 0;

        switch($voucher->getDiscountOperation()) {
            case VoucherCodeModel::DISCOUNT_SUBTOTAL:
                $subTotal = $service->getSubTotal();

                if ($voucher->getDiscountAmount() > $subTotal) {
                    $discount = $subTotal;
                } else {
                    $discount = $voucher->getDiscountAmount();
                }
                break;
            case VoucherCodeModel::DISCOUNT_SUBTOTAL_PERCENTAGE:
                $subTotal = $service->getSubTotal();
                $discount = (($subTotal) / 100) * $voucher->getDiscountAmount();
                break;
            case VoucherCodeModel::DISCOUNT_CATEGORY:
                $catSubTotal = 0;

                foreach ($items as $item) {
                    $catSubTotal += $item->getPrice() * $item->getQuantity();
                }

                if ($voucher->getDiscountAmount() > $catSubTotal) {
                    $discount = $catSubTotal;
                } else {
                    $discount = $voucher->getDiscountAmount();
                }
                break;
            case VoucherCodeModel::DISCOUNT_CATEGORY_PERCENTAGE:
                $catSubTotal = 0;

                foreach ($items as $item) {
                    $catSubTotal += $item->getPrice() * $item->getQuantity();
                }

                $discount = (($catSubTotal) / 100) * $voucher->getDiscountAmount();
                break;
            case VoucherCodeModel::DISCOUNT_SHIPPING:
                $shipping = $service->getShippingCost() + $service->getShippingTax();

                if ($voucher->getDiscountAmount() > $shipping) {
                    $discount = $shipping;
                } else {
                    $discount = $voucher->getDiscountAmount();
                }
                break;
            case VoucherCodeModel::DISCOUNT_SHIPPING_PERCENTAGE:
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

        $code = ($model instanceof VoucherCodeModel && $model->getCode() === $post['code']) ? $model->getCode() : null;

        /* @var $inputFilter \Shop\InputFilter\VoucherCodeInputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addNoRecordExists($code);

        $hydrator = $form->getHydrator();
        /* @var DateTime $dateTimeStrategy */
        $dateTimeStrategy = $hydrator->getStrategy('startDate');
        $dateTimeStrategy->setHydrateFormat('Y-m-d');
        $dateTimeStrategy = $hydrator->getStrategy('expiry');
        $dateTimeStrategy->setHydrateFormat('Y-m-d');
    }

    /**
     * @param VoucherCodeModel $code
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function toggleEnabled(VoucherCodeModel $code)
    {
        $this->removeCacheItem($code->getVoucherId());

        $enabled = (true === $code->isActive()) ? false : true;

        $code->setActive($enabled);

        return $this->save($code);
    }
}