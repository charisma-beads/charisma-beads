<?php
namespace Shop\Service\Cart;

use Application\Service\AbstractService;

class Item extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\CartItem';
    
    /**
     * @param int $cartId
     */
    public function getCartItemsByCartId($cartId)
    {
        $cartId = (int) $cartId;
        return $this->getMapper()->getCartItemsByCartId($cartId);
    }
}