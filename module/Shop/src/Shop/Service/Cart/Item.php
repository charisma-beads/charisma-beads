<?php
namespace Shop\Service\Cart;

use UthandoCommon\Service\AbstractMapperService;

class Item extends AbstractMapperService
{
    protected $serviceAlias = 'ShopCartItem';

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
