<?php
namespace Shop\Hydrator\Product;

use UthandoCommon\Hydrator\AbstractHydrator;

class Group extends AbstractHydrator
{
    /**
     * @param \Shop\Model\Product\Group $object
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
