<?php
namespace Navigation\Hydrator;

use Application\Hydrator\AbstractHydrator;

class Page extends AbstractHydrator
{
	protected $addDepth = false;
	/**
	 * @param \Navigation\Model\Page $object
	 * @return array $data
	 */
	public function extract($object)
	{
		$data = array(
			'pageId'	=> $object->getPageId(),
			'menuId'	=> $object->getMenuId(),
			'label'		=> $object->getLabel(),
			'params'	=> $object->getParams(),
			'route'		=> $object->getRoute(),
			'uri'		=> $object->getUri(),
			'resource'	=> $object->getResource(),
			'visible'	=> $object->getVisible(),
			'lft'		=> $object->getLft(),
			'rgt'		=> $object->getRgt()
		);
		
		if (true === $this->addDepth) {
			$data['depth'] = $object->getDepth();
		}
		
		return $data;
	}
	
	public function addDepth()
	{
		$this->addDepth = true;
	}
}
