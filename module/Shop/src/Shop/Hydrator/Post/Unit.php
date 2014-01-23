<?php
namespace Shop\Hydrator\Post;

use Application\Hydrator\AbstractHydrator;

class Unit extends AbstractHydrator
{
    protected $prefix = 'postUnit.';
    
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
