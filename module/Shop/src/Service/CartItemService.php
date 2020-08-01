<?php

namespace Shop\Service;

use Shop\Hydrator\CartItemHydrator;
use Shop\Mapper\CartItemMapper;
use Shop\Model\CartItemModel;
use Common\Service\AbstractMapperService;

/**
 * Class Item
 *
 * @package Shop\Service
 */
class CartItemService extends AbstractMapperService
{
    protected $hydrator     = CartItemHydrator::class;
    protected $mapper       = CartItemMapper::class;
    protected $model        = CartItemModel::class;

    /**
     * @param $cartId
     * @return mixed
     */
    public function getCartItemsByCartId($cartId)
    {
        $cartId = (int) $cartId;
        return $this->getMapper()->getCartItemsByCartId($cartId);
    }
}
