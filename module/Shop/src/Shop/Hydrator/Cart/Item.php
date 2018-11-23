<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Cart;

use UthandoCommon\Hydrator\AbstractHydrator;
use Shop\Hydrator\Strategy\Serialize;
use Shop\Hydrator\Strategy\Percent;

/**
 * Class Item
 *
 * @package Shop\Hydrator\Cart
 */
class Item extends AbstractHydrator
{
    public Function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('metadata', new Serialize());
        $this->addStrategy('tax', new Percent());
    }
    
    /**
     * @param \Shop\Model\Cart\Item $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'cartItemId'    => $object->getCartItemId(),
            'cartId'        => $object->getCartId(),
            'quantity'      => $object->getQuantity(),
            'price'         => $object->getPrice(),
            'tax'           => $this->extractValue('tax', $object->getTax()),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        ];
    }
}
