<?php
namespace Application\Hydrator;

use Application\Model\Session;

class Session extends AbstractHydrator
{
	public function extract(Session $object)
	{
		return array(
			'id'		=> $object->getId(),
			'modified'	=> $object->getModified(),
			'lifetime'	=> $object->getLifetime(),
			'name'		=> $object->getName(),
			'data'		=> $object->getData()
		);
	}
}
