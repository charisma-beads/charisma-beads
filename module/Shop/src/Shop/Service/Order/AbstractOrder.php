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

use Shop\Model\Order\AbstractOrderCollection;
use Shop\Options\ShopOptions;
use Shop\Service\Shipping;
use Shop\Service\Tax\Tax;
use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class AbstractOrder
 *
 * @package Shop\Service\Order
 */
class AbstractOrder extends  AbstractRelationalMapperService
{
    /**
     * @var AbstractOrderCollection
     */
    protected $orderModel;

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
     * @return AbstractOrderCollection
     */
    public function getOrderModel(): AbstractOrderCollection
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
