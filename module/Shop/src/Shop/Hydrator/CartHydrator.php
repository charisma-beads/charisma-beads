<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;

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
