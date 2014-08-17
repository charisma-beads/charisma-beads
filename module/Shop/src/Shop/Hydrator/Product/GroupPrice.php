<?php
namespace Shop\Hydrator\Product;

use UthandoCommon\Hydrator\AbstractHydrator;

class GroupPrice extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Product\GroupPrice $object
     * @return array
     */
    public function extract($object)
    {
        return array(
        	'productGroupId'   => $object->getProductGroupId(),
            'group'            => $object->getGroup(),
            'price'            => $object->getPrice(),
        );
    }
}
