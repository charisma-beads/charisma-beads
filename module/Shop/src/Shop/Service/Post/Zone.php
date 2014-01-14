<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Zone extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\PostZone';
	protected $form = 'Shop\Form\PostZone';
	protected $inputFilter = 'Shop\InputFilter\PostZone';
	
	public function searchZones(array $post)
	{
		$zone = (isset($post['zone'])) ? (string) $post['zone'] : '';
		$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	
		//$this->getMapper()->useModelRelationships(true);
	
		$zones = $this->getMapper()->searchZones($zone, $sort);
	
		return $zones;
	}
}
