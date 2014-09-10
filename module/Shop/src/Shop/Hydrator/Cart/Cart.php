<?php
namespace Shop\Hydrator\Cart;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;

class Cart extends AbstractHydrator
{
    public Function __construct()
    {
        parent::__construct();
    
        $this->addStrategy('dateModified', new DateTimeStrategy());
    }
    
    /**
     *
     * @param \Shop\Model\Cart\Cart $object
     * @return array $data
     */
    public function extract($object)
    {
        return array(
        	'cartId'        => $object->getCartId(),
            'verifyId'      => $object->getVerifyId(),
            'expires'       => $object->getExpires(),
            'dateModified'  => $this->extractValue('dateModified', $object->getDateModified()),
        );
    }
}
