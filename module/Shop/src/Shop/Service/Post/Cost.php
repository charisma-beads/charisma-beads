<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;
use Shop\Model\Post\Cost as PostCostModel;

class Cost extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\PostCost';
	protected $form = 'Shop\Form\PostCost';
	protected $inputFilter = 'Shop\InputFilter\PostCost';
	
	/**
	 * @var \Shop\Service\Post\Level
	 */
	protected $postLevelService;
	
	/**
	 * @var \Shop\Service\Post\Zone
	 */
	protected $postZoneService;
	
	public function searchCosts(array $post)
	{
		$cost = (isset($post['cost'])) ? (string) $post['cost'] : '';
		$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
	
		//$this->getMapper()->useModelRelationships(true);
	
		$costs = $this->getMapper()->searchCosts($cost, $sort);
		
		foreach ($costs as $cost) {
			$this->populate($cost, true);
		}
	
		return $costs;
	}
	
	public function populate(PostCostModel $cost, $children = false)
	{
		$allChildren = ($children === true) ? true : false;
		$children = (is_array($children)) ? $children : array();
		
		if ($allChildren || in_array('postLevel', $children)) {
			$id = $cost->getPostLevelId();
			$cost->setRelationalModel($this->getPostLevelService()->getById($id));
		}
		
		if ($allChildren || in_array('postZone', $children)) {
			$id = $cost->getPostZoneId();
			$cost->setRelationalModel($this->getPostZoneService()->getById($id));
		}
	}
	
	/**
	 * @return \Shop\Service\Post\Level
	 */
	public function getPostLevelService()
	{
		if (!$this->postLevelService) {
			$sl = $this->getServiceLocator();
			$this->postLevelService = $sl->get('Shop\Service\PostLevel');
		}
	
		return $this->postLevelService;
	}
	
	/**
	 * @return \Shop\Service\Post\Zone
	 */
	public function getPostZoneService()
	{
		if (!$this->postZoneService) {
			$sl = $this->getServiceLocator();
			$this->postZoneService = $sl->get('Shop\Service\PostZone');
		}
		
		return $this->postZoneService;
	}
	
}
