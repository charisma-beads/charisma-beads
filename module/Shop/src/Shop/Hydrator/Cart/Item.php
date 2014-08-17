<?php
namespace Shop\Hydrator\Cart;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\Serialize;
use Shop\Hydrator\Strategy\Percent;

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
        return array(
        	'cartItemId'    => $object->getCartItemId(),
            'cartId'        => $object->getCartId(),
            'quantity'      => $object->getQuantity(),
            'price'         => $object->getPrice(),
            'tax'           => $this->extractValue('tax', $object->getTax()),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        );
    }
}
