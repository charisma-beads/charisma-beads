<?php

namespace Shop\Service;

use Shop\Model\ProductOptionModel;
use Shop\Hydrator\ProductMetaDataHydrator;
use Shop\Model\AbstractOrderCollection;
use Shop\Model\OrderLineInterface;
use Shop\Model\ProductMetaDataModel;
use Shop\Model\ProductModel;
use Shop\Options\ShopOptions;
use Common\Service\AbstractMapperService;
use Common\Service\AbstractRelationalMapperService;

/**
 * Class AbstractOrder
 *
 * @package Shop\Service
 * @method AbstractMapperService getService($service)
 */
abstract class AbstractOrderService extends AbstractRelationalMapperService
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
     * @var ShippingService
     */
    protected $shippingService;

    /**
     * @var TaxService
     */
    protected $taxService;

    /**
     * @param AbstractOrderCollection $orderModel
     * @return AbstractOrderCollection
     * @throws \Common\Model\CollectionException
     * @throws \Common\Service\ServiceException
     */
    public function loadItems(AbstractOrderCollection $orderModel)
    {
        $itemsService = $this->getRelatedService($this->lineService);

        $method = $this->getReferenceMap()[$this->lineService]['getMethod'];
        $items = $itemsService->$method($orderModel->getId());

        /* @var $item OrderLineInterface */
        foreach ($items as $item) {
            $productId = $item->getMetadata()->getProductId();
            $productOption = ($item->getMetadata()->getOption()) ?: null;

            if ($productOption instanceof ProductOptionModel) {
                $productId = $productId . '-' . $productOption->getProductOptionId();
            }

            $orderModel->offsetSet($productId, $item);
        }

        return $orderModel;
    }

    /**
     * Remove an line item for the order collection
     *
     * @param $id
     * @throws \Common\Service\ServiceException
     */
    public function removeItem($id)
    {
        $this->getRelatedService($this->lineService)->delete($id);
    }

    /**
     * calculates the item line price
     *
     * @param OrderLineInterface $item
     * @return number
     */
    public function getLineCost(OrderLineInterface $item)
    {
        $priceTax = $this->calculateTax($item);
        $price = $priceTax['price'];
        $tax = $priceTax['tax'];

        $this->getOrderModel()->setTaxTotal($tax);

        //$price = ($item->getMetadata()->getVatInc()) ? $price + $tax : $price;

        return $price * $item->getQuantity();
    }

    /**
     * @param OrderLineInterface $item
     * @return array
     */
    public function calculateTax(OrderLineInterface $item)
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

    abstract public function calculateTotals();

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
     * @return ProductMetaDataModel
     */
    public function getProductMetaData(ProductModel $product, $optionId)
    {
        $hydrator = new ProductMetaDataHydrator($optionId);
        $model    = $this->getModel(ProductMetaDataModel::class);

        /*  @var ProductMetaDataModel $metadata */
        $metadata = $hydrator->hydrate($product->getArrayCopy(), $model);
        return $metadata;
    }

    /**
     * @param OrderLineInterface $item
     * @return mixed
     */
    abstract public function persist(OrderLineInterface $item = null);

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
        return $this->getServiceLocator()->get(ShopOptions::class);
    }

    /**
     * @return ShippingService
     */
    protected function getShippingService()
    {
        if (!$this->getOrderModel()->getShipping() instanceof ShippingService) {
            $this->shippingService = $this->getServiceLocator()
                ->get(ShippingService::class);
        }

        return $this->shippingService;
    }

    /**
     * @return TaxService
     */
    public function getTaxService()
    {
        if (! $this->taxService instanceof TaxService) {
            $sl = $this->getServiceLocator();
            $this->taxService = $sl->get(TaxService::class);
        }

        return $this->taxService;
    }
}
