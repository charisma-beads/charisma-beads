<?php
namespace Shop\Mapper\Cart;

use Application\Mapper\AbstractMapper;

class Item extends AbstractMapper
{
    protected $table = 'cartItem';
    protected $primary = 'cartItemId';
    protected $model = 'Shop\Model\Cart\Item';
    protected $hydrator = 'Shop\Hydrator\Cart\Item';
    
    public function getCartItemsByCartId($cartId)
    {
        $select = $this->getSelect();
        $select->where->equalTo('cartId', $cartId);
        
        return $this->fetchResult($select);
    }
}
