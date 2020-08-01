<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Group
 *
 * @package Shop\Hydrator
 */
class ProductGroupHydrator extends AbstractHydrator
{
    /**
     * @param \Shop\Model\ProductGroupModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
        	'productGroupId'   => $object->getProductGroupId(),
            'group'            => $object->getGroup(),
            'price'            => $object->getPrice(),
        ];
    }
}
