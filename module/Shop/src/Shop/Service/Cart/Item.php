<?php
namespace Shop\Service\Cart;

use UthandoCommon\Service\AbstractService;

class Item extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Cart\Item';

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
