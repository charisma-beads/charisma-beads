<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Level extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\PostLevel';
	protected $form = 'Shop\Form\PostLevel';
	protected $inputFilter = 'Shop\InputFilter\PostLevel';
	
	public function searchLevels(array $post)
	{
		$level = (isset($post['postLevel'])) ? (string) $post['postLevel'] : '';
		$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	
		//$this->getMapper()->useModelRelationships(true);
	
		$levels = $this->getMapper()->searchLevels($level, $sort);
	
		return $levels;
	}
}
