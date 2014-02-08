<?php
namespace Shop\Hydrator;

use Application\Hydrator\AbstractHydrator;
use Application\Hydrator\Strategy\DateTime as DateTimeStrategy;

class Cart extends AbstractHydrator
{
    public Function __construct($useRelationships)
    {
        parent::__construct();
    
        $this->useRelationships = $useRelationships;
    
        $this->addStrategy('dateCreated', new DateTimeStrategy());
    }
    
    /**
     *
     * @param \Shop\Model\Cart $object            
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'cartId'        => $object->getCartId(),
            'verifyId'      => $object->getVerifyId(),
            'expires'       => $object->getExpires(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
        );
    }
}
