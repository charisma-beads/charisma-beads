<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;

/**
 * Class Cart
 *
 * @package Shop\Hydrator
 */
class CartHydrator extends AbstractHydrator
{
    public Function __construct()
    {
        parent::__construct();
    
        $this->addStrategy('dateModified', new DateTimeStrategy());
    }
    
    /**
     *
     * @param \Shop\Model\CartModel $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'cartId'        => $object->getCartId(),
            'verifyId'      => $object->getVerifyId(),
            'expires'       => $object->getExpires(),
            'dateModified'  => $this->extractValue('dateModified', $object->getDateModified()),
        ];
    }
}
