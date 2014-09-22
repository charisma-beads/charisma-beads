<?php
namespace Shop\Mapper\Cart;

use UthandoCommon\Mapper\AbstractMapper;

class Item extends AbstractMapper
{
    protected $table = 'cartItem';
    protected $primary = 'cartItemId';
    
    public function getCartItemsByCartId($cartId)
    {
        $select = $this->getSelect();
        $select->where->equalTo('cartId', $cartId);
        
        return $this->fetchResult($select);
    }
}
