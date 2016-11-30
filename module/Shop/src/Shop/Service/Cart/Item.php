<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Cart;

use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Item
 *
 * @package Shop\Service\Cart
 */
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
