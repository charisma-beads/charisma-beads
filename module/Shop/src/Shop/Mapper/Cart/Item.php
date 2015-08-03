<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Cart;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Item
 *
 * @package Shop\Mapper\Cart
 */
class Item extends AbstractDbMapper
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
