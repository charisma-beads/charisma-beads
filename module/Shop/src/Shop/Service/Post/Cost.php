<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Cost extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\PostCostl';
	protected $form = 'Shop\Form\PostCost';
	protected $inputFilter = 'Shop\InputFilter\PostCost';
	
	public function searchLevels(array $post)
	{
		$cost = (isset($post['cost'])) ? (string) $post['cost'] : '';
		$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	
		//$this->getMapper()->useModelRelationships(true);
	
		$costs = $this->getMapper()->searchLevels($cost, $sort);
	
		return $costs;
	}
}
