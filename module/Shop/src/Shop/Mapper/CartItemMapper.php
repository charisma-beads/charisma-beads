<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractDbMapper;

/**
 * Class Item
 *
 * @package Shop\Mapper\Cart
 */
class CartItemMapper extends AbstractDbMapper
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
