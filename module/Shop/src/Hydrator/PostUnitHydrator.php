<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Unit
 *
 * @package Shop\Hydrator
 */
class PostUnitHydrator extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\PostUnitModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'postUnitId'	    => $object->getPostUnitId(),
			'postUnit'			=> $object->getPostUnit()
        ];
	}
}
