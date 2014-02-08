<?php
namespace Shop\Hydrator\Cart;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\Serialize;
use Shop\Hydrator\Strategy\Percent;

class Item extends AbstractHydrator
{
    public Function __construct($useRelationships)
    {
        parent::__construct();
    
        $this->useRelationships = $useRelationships;
        
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
            'description'   => $object->getDescription(),
            'quantity'      => $object->getQuantity(),
            'price'         => $object->getPrice(),
            'tax'           => $this->extractValue('tax', $object->getTax()),
            'metadata'      => $this->extractValue('metadata', $object->getMetadata()),
        );
    }
}
