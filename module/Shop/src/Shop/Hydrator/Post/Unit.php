<?php
namespace Shop\Hydrator\Post;

use UthandoCommon\Hydrator\AbstractHydrator;

class Unit extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Post\Unit $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return array(
			'postUnitId'	    => $object->getPostUnitId(),
			'postUnit'			=> $object->getPostUnit()
		);
	}
}
