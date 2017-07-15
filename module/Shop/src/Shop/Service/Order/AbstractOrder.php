<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Service\Order;

use Shop\Model\Product\Option as ProductOption;
use Shop\Hydrator\Product\MetaData;
use Shop\Model\Order\AbstractOrderCollection;
use Shop\Model\Order\LineInterface;
use Shop\Model\Product\MetaData as ProductMetaData;
use Shop\Model\Product\Product as ProductModel;
use Shop\Options\ShopOptions;
use Shop\Service\Product\Product as ProductService;
use Shop\Service\Shipping;
use Shop\Service\Tax\Tax;
use UthandoCommon\Service\AbstractMapperService;
use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class AbstractOrder
 *
 * @package Shop\Service\Order
 * @method AbstractMapperService getService($service)
 */
abstract class AbstractOrder extends AbstractRelationalMapperService
{
    /**
     * @var AbstractOrderCollection
     */
    protected $orderModel;

    /**
     * @var string
     */
    protected $lineService;

    /**
     * @var bool
     */
    protected $useCache = false;

    /**
     * @var Shipping
     */
    protected $shippingService;

    /**
     * @var Tax
     */
    protected $taxService;

    /**
     * @param AbstractOrderCollection $orderModel
     * @return AbstractOrderCollection
     */
    public function loadItems(AbstractOrderCollection $orderModel)
    {
        $itemsService = $this->getRelatedService($this->lineService);

        $method = $this->getReferenceMap()[$this->lineService]['getMethod'];
        $items = $itemsService->$method($orderModel->getId());

        /* @var $item LineInterface */
        foreach ($items as $item) {
            $productId = $item->getMetadata()->getProductId();
            $productOption = ($item->getMetadata()->getOption()) ?: null;

            if ($productOption instanceof ProductOption) {
                $productId = $productId . '-' . $productOption->getProductOptionId();
            }

            $orderModel->offsetSet($productId, $item);
        }

        return $orderModel;
    }

    /**
     * Adds items contained with the order collection
     *
     * @param ProductModel $product
     * @param array $post
     * @return LineInterface|bool
     */
    public function addItem(ProductModel $product, $post)
    {
        $qty = $post['qty'];

        if ($qty <= 0 || $product->inStock() === false || $product->isDiscontinued() === true || $product->isEnabled() === false) {
            return false;
        }

        $productClone = clone $product;

        $productId = $productClone->getProductId();
        $optionId = (isset($post['ProductOptionList'])) ? (int) substr(strrchr($post['ProductOptionList'], "-"), 1) : null;

        $productOption = ($optionId) ? $product->getProductOption($optionId) : null;

        if ($productOption instanceof ProductOption) {
            $productClone->setPostUnitId($productOption->getPostUnitId())
                ->setPostUnit($productOption->getPostUnit())
                ->setPrice($productOption->getPrice(false))
                ->setDiscountPercent($productOption->getDiscountPercent());
            $productId = $productId . '-' . $optionId;
        }

        $model = $this->getOrderModel();
        $lineModel = $model->getEntityClass();

        /** @var $line LineInterface */
        $line = ($model->offsetExists($productId)) ? $model->offsetGet($productId) : new $lineModel();

        if ($model->isAutoIncrementQuantity()) {
            $qty = $qty + $line->getQuantity();
        }

        $argv = compact('product', 'qty', 'line');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('stock.check', $this, $argv);

        $qty = $argv['qty'];

        if (0 == $qty) {
            $this->removeItem($line->getId());
            return false;
        }

        $line->setPrice($productClone->getPrice())
            ->setQuantity($qty)
            ->setTax($productClone->getTaxCode()->getTaxRate()->getTaxRate())
            ->setMetadata($this->getProductMetaData($productClone, $optionId))
            ->setParentId($model->getId());

        $model->offsetSet($productId, $line);

        $this->persist($line);

        $this->getEventManager()->trigger('stock.save', $this, $argv);

        return $line;
    }

    /**
     * Updates order items.
     *
     * @param array $items
     */
    public function updateItem(array $items)
    {
        $orderModel = $this->getOrderModel();

        foreach ($items as $lineItemId => $qty) {

            $line = $orderModel->getLineById($lineItemId);

            if (!$line || $qty < 0) continue;

            if ($qty == 0) {
                $this->removeItem($lineItemId);
            } else {

                /* @var $productService ProductService */
                $productService = $this->getService('ShopProduct');
                $product = $productService->getById($line->getMetadata()->getProductId());

                $argv = compact('product', 'qty', 'line');
                $argv = $this->prepareEventArguments($argv);

                $this->getEventManager()->trigger('stock.check', $this, $argv);

                $qty = $argv['qty'];

                $line->setQuantity($qty);

                $offsetKey = $line->getMetadata()->getProductId();

                // check for option
                if ($line->getMetadata()->getOption() instanceof ProductOption) {
                    $offsetKey = join('-', [
                        $offsetKey,
                        $line->getMetadata()->getOption()->getProductOptionId()
                    ]);
                }

                $orderModel->offsetSet($offsetKey, $line);

                $this->getEventManager()->trigger('stock.save', $this, $argv);
            }
        }

        $this->persist();
    }

    /**
     * Remove an line item for the order collection
     *
     * @param $id
     */
    public function removeItem($id)
    {
        $item = $this->getRelatedService($this->lineService)->getById($id);
        $argv = compact('item');
        $argv = $this->prepareEventArguments($argv);

        $this->getEventManager()->trigger('stock.restore', $this, $argv);
        $this->getRelatedService($this->lineService)->delete($id);
    }

    /**
     * calculates the item line price
     *
     * @param LineInterface $item
     * @return number
     */
    public function getLineCost(LineInterface $item)
    {
        $priceTax = $this->calculateTax($item);
        $price = $priceTax['price'];
        $tax = $priceTax['tax'];

        $this->getOrderModel()->setTaxTotal($tax);

        //$price = ($item->getMetadata()->getVatInc()) ? $price + $tax : $price;

        return $price * $item->getQuantity();
    }

    /**
     * @param LineInterface $item
     * @return array
     */
    public function calculateTax(LineInterface $item)
    {
        if (true == $this->getShopOptions()->isVatState()) {
            $taxService = $this->getTaxService()
                ->setTaxState($this->getShopOptions()->isVatState())
                ->setTaxInc($item->getMetadata()->getVatInc());
            $taxService->addTax($item->getPrice(), $item->getTax());

            $price  = $taxService->getPrice();
            $tax    = $taxService->getTax();
        } else {
            $price  = $item->getPrice();
            $tax    = 0;
        }

        return ['price' => $price, 'tax' => $tax];

    }

    /**
     * Calculate the totals
     */
    public function calculateTotals()
    {
        $sub = 0;
        $this->getOrderModel()->setTaxTotal(0);

        $orderModel = ($this->getOrderModel()) ?? [];

        foreach($orderModel as $lineItem) {
            $sub = $sub + $this->getLineCost($lineItem);
        }

        $orderModel->setSubTotal($sub);
        $orderModel->setTotal($orderModel->getSubTotal() + $orderModel->getShipping());

        $this->getEventManager()->trigger('cart.voucher.check', $this);
    }

    /**
     * Set the shipping cost
     *
     * @param null|int $countryId
     * @return $this
     */
    public function setShippingCost($countryId = null)
    {
        if ($countryId) {
            $countryId = (int) $countryId;
            $shipping = $this->getShippingService();
            $shipping->setCountryId($countryId);

            $cost = $shipping->calculateShipping($this->getOrderModel());
            $this->setShippingTax($shipping->getShippingTax());
        } else {
            $cost = 0;
            $this->setShippingTax(0);
        }

        $this->getOrderModel()->setShipping($cost);
        $this->calculateTotals();
        return $this;
    }

    /**
     * @return float
     */
    public function getShippingTax()
    {
        return $this->getOrderModel()->getShippingTax();
    }

    /**
     * @param float $shippingTax
     * @return $this
     */
    public function setShippingTax($shippingTax)
    {
        $this->getOrderModel()->setShippingTax($shippingTax);
        return $this;
    }

    /**
     * Get the shipping cost
     *
     * @return float
     */
    public function getShippingCost()
    {
        //$this->calculateTotals();
        return $this->getOrderModel()->getShipping();
    }

    /**
     * Get the sub total
     *
     * @return float
     */
    public function getSubTotal()
    {
        //$this->calculateTotals();
        return $this->getOrderModel()->getSubTotal();
    }

    /**
     * Get the basket total
     *
     * @return float
     */
    public function getTotal()
    {
        //$this->calculateTotals();
        return $this->getOrderModel()->getTotal() + $this->getTaxTotal();
    }

    /**
     * Get the tax total
     *
     * @return float
     */
    public function getTaxTotal()
    {
        //$this->calculateTotals();
        return $this->getOrderModel()->getTaxTotal() + $this->getOrderModel()->getShippingTax();
    }

    /**
     * Checks if order model has any items.
     *
     * @return boolean
     */
    public function hasItems()
    {
        $orderModel = $this->getOrderModel();

        if ($orderModel->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param ProductModel $product
     * @param int $optionId
     * @return ProductMetaData
     */
    public function getProductMetaData(ProductModel $product, $optionId)
    {
        $hydrator = new MetaData($optionId);
        $model    = $this->getModel('ShopProductMetaData');

        /*  @var ProductMetaData $metadata */
        $metadata = $hydrator->hydrate($product->getArrayCopy(), $model);
        return $metadata;
    }

    /**
     * @param LineInterface $item
     * @return mixed
     */
    abstract public function persist(LineInterface $item = null);

    /**
     * @return AbstractOrderCollection
     */
    public function getOrderModel()
    {
        return $this->orderModel;
    }

    /**
     * @param AbstractOrderCollection $orderModel
     * @return $this
     */
    public function setOrderModel($orderModel)
    {
        $this->orderModel = $orderModel;
        return $this;
    }

    /**
     * @return ShopOptions
     */
    public function getShopOptions()
    {
        return $this->getServiceLocator()->get('Shop\Options\Shop');
    }

    /**
     * @return Shipping
     */
    protected function getShippingService()
    {
        if (!$this->getOrderModel()->getShipping() instanceof Shipping) {
            $this->shippingService = $this->getServiceLocator()
                ->get('Shop\Service\Shipping');
        }

        return $this->shippingService;
    }

    /**
     * @return Tax
     */
    public function getTaxService()
    {
        if (! $this->taxService instanceof Tax) {
            $sl = $this->getServiceLocator();
            $this->taxService = $sl->get('Shop\Service\Tax');
        }

        return $this->taxService;
    }
}
